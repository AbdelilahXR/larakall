<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Order;
use App\Models\Conversation;
use App\Models\Message;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;

class TopNavBar extends Component implements HasForms
{
    use InteractsWithForms;

 /* make a appendix of methods in this class
    ** 1. mount
    ** 2. openChat (open chat window)
    ** 3. form (form schema)
    ** 4. fetchConversations (fetch conversations)
    ** 5. createNewConversation (submit new conversation)
    ** 6. showConversation (show conversation using conversation id)
    ** 7. replyOnConversation (reply on conversation)
    ** 8. showInbox (show inbox conversations)
    ** 9. loadMoreConversations (load more conversations)
    ** 10. startChat (start new chat)
    ** 11. refreshConversations
    ** 12. refreshConversation
    ** 13. closeAll
    ** 14. refreshUnreadMessages
    ** 15. render
*/


    public $currentConversation;
    public $messages = [];
    public $conversations = [];
    public $unreadMessages = 0;
    public $perPage;
    public $newChat = false;
    public $showInboxContainer = true;	
    public $showConversationContainer = false;
    public ?array $data = [];
    
    protected $listeners = ['refreshMessages' => '$refresh', 'modal-order-id' => 'startChat'];

    public function openChat()
    {   
        $this->refreshUnreadMessages();
        $this->closeAll();
        $this->showInbox();
        $this->dispatch('refreshMessages');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('receiver')
                    ->label(__('all.receiver'))
                    ->options(
                        auth()->user()->hasRole('super_admin') ? 
                            User::pluck('name', 'id')->toArray() :
                            User::whereHas('roles', function ($query) {
                            $query->where('name', 'super_admin');
                        })->pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->required(),
                MarkdownEditor::make('content')
                    ->required()
                    ->label(__('all.message'))
                    ->placeholder(__('all.your_message_here'))
                    ->toolbarButtons([
                        'attachFiles',
                        'link',
                        'undo',
                    ])
                    ->fileAttachmentsDirectory('message_attachments')
                    ->fileAttachmentsVisibility('private'),
                Select::make('orders_id')
                    ->label(__('all.order_code'))
                    ->options(
                        Order::filterByUser()->get()->pluck('code', 'id')->toArray()
                    )
                    ->searchable(),
            ])
            ->statePath('data');
    }

    public function fetchConversations($perPage = 10)
    {
        $conversations = Conversation::where('sender', auth()->id())
            ->orWhere('receiver', auth()->id())
            ->with('lastMessage')
            ->orderBy('last_send', 'desc')
            ->with('lastMessage')
            ->paginate($perPage);
        $this->conversations = $conversations->getCollection()->all();
    }

    public function createNewConversation()
    {

        $rules = [
            'receiver' => 'required|exists:users,id',
            'content' => 'required',
        ];

        if ($this->data['orders_id']) {
            $rules['orders_id'] = 'required|exists:orders,id';
        }


        $validation = Validator::make($this->data, $rules);

        if ($validation->fails()) {
            Notification::make()
                ->title(__('all.error'))
                ->danger()
                ->body($validation->errors()->first())
                ->send();
            return;
        }

        $receiver = User::find($this->data['receiver']);
        if (!$receiver->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            Notification::make()
                ->title(__('all.error'))
                ->danger()
                ->body(__('all.you_can_only_send_messages_to_support_agents'))
                ->send();
            return;
        }

        // if reciever is user itself return error
        if ($this->data['receiver'] == auth()->id()) {
            Notification::make()
                ->title(__('all.error'))
                ->danger()
                ->body(__('all.you_cannot_send_message_to_yourself'))
                ->send();
            return;
        }
        
        $conversation = Conversation::create([
            'sender' => auth()->id(),
            'receiver' => $this->data['receiver'] ?? null,
            'orders_id' => $this->data['orders_id'] ?? null,
            'is_read' => '0',
            'last_send' => now()
        ]);

        $conversation->messages()->create([
            'message' => $this->escapeTags($this->markdownToHtml($this->data['content'])) ?? null,
            'users_id' => auth()->id(),
        ]);

        Notification::make()
            ->title(__('all.success'))
            ->success()
            ->body(__('all.message_sent_successfully'))
            ->send();

        $this->closeAll();
        $this->showConversation($conversation->id);
    }
    

    public function showConversation($conversationId)
    {    
        $this->closeAll();
        $this->data['content'] = '';
        $this->currentConversation = $conversationId;
        
        $conversation = Conversation::where('id', $conversationId)->with('messages')->get();

        if (!$conversation) {
            $this->showInbox();
            return;
        }

        $this->messages = $conversation->first()->messages;

        if ($conversation->first()->receiver == auth()->id()) {
            $conversation->first()->update(['is_read' => 1]);
        }

        $this->showConversationContainer = true;
        $this->refreshUnreadMessages();
    }

    public function replyOnConversation()
    {
        $conversation = Conversation::find($this->currentConversation);

        if (!$conversation) {
            $this->showInbox();
            return;
        }

        $conversation->messages()->create([
            'message' => $this->escapeTags($this->data['content']),
            'users_id' => auth()->id(),
        ]);

        $conversation->update([
            'is_read' => 0,
            'sender' => auth()->id(),
            'receiver' => $conversation->sender == auth()->id() ? $conversation->receiver : $conversation->sender,
            'last_send' => now()
        ]);

        
        $this->dispatch('refreshMessages');
        $this->showConversation($conversation->id);

    }

    public function showInbox()
    {
        $this->closeAll();
        $this->fetchConversations(10);
        $this->showInboxContainer = true;
    }

    public function loadMoreConversations()
    {
        $this->perPage += 10;
        $this->fetchConversations($this->perPage);
    }


    public function startChat($data = [])
    {
        $this->closeAll();
        $this->newChat = true;
        $this->data = [
            'orders_id' => null,
            'receiver' => '',
            'content' => '',
        ];

        $this->form->fill(
             ['orders_id' => $data['orders_id'] ?? null]
        );
    }

    public function refreshConversations()
    {
        $this->fetchConversations(10);
        $this->dispatch('refreshMessages');
    }

    public function refreshConversation()
    {
        $conversation = Conversation::find($this->currentConversation);

        if (!$conversation) {
            $this->showInbox();
            return;
        }

        $this->showConversation($conversation->id);
    }

    public function closeAll()
    {
        $this->showInboxContainer = false;
        $this->showConversationContainer = false;
        $this->newChat = false;
        $this->currentConversation = null;
        $this->messages = null;
        $this->refreshUnreadMessages();
    }

    public function refreshUnreadMessages()
    {
        $this->unreadMessages = Conversation::where('receiver', auth()->id())->where('is_read', 0)->count();
    }


    function markdownToHtml($markdown) {
        $markdown = preg_replace("/\!\[(.*?)\]\((.*?)\)/", "<img src=\"$2\" alt=\"$1\">", $markdown);
        $markdown = preg_replace("/\[(.*?)\]\((.*?)\)/", "$2", $markdown);
        return $markdown;
    }

    function escapeTags($text)
    {
        return strip_tags($text, '<img><div><p><br>');
    }

    function conversationInfos($conversation)
    {
        $img = $conversation->sender != auth()->user()->id ? $conversation->senderUser->getFilamentAvatarUrl() : $conversation->receiverUser->getFilamentAvatarUrl();
        $name = $conversation->sender != auth()->user()->id ? $conversation->senderUser->name : $conversation->receiverUser->name;

        return (object) [
            'img' => $img ?? null,
            'name' => $name ?? null,
        ];
    }

    public function render()
    {
        return view('livewire.topbar-chat-box');
    }
}

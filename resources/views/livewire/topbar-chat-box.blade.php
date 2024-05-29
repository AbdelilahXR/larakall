<div class="flex justify-between items-center w-full  lg:order-none  order-1">
    <div class="flex gap-4">
        <!-- First gap -->
    </div>
    <div class="flex gap-4">
        <!-- Second gap -->
    </div>
    <div class="flex gap-4">
            <!-- <button x-on:click="$dispatch('open-modal', {id: 'chat-Modal'})">
                open
            </button> -->

            <x-filament::modal slide-over sticky-footer id="chat-Modal">
                <x-slot name="trigger" wire:click="openChat">
                <x-filament::icon-button icon="heroicon-o-envelope" size="lg" color="gray" label="Message">
                    <x-slot name="badge">{{ $this->unreadMessages }}</x-slot>
                </x-filament::icon-button>
                </x-slot>
                <x-slot name="heading">Messages</x-slot>

                    @if($this->newChat)
                        {{ $this->form }}
                    @endif
                    @if($this->showConversationContainer && $this->currentConversation && $this->messages)
                        <div style="margin: 0 -20px; height: 163%; margin-bottom: -31px">
                            <div class="flex flex-col h-full flex-grow w-full max-w-xl shadow-xl rounded-lg overflow-hidden">
                                <div class="flex flex-col flex-grow h-0 p-4 overflow-auto" style="flex-direction: column-reverse;">
                                    @forelse ($this->messages as $message)
                                        @if($message->users_id == auth()->id())
                                            <div class="flex w-full mt-2 space-x-3 max-w-xs ml-auto justify-end">
                                                <div>
                                                    <div class="bg-blue-600 text-white p-3 rounded-l-lg rounded-br-lg">
                                                        <p class="text-sm break-words"  style="overflow-wrap: anywhere">{!! $this->escapeTags($message->message) !!}</p>
                                                    </div>
                                                    <span class="text-xs text-gray-500 leading-none">{{ $message->created_at->diffForHumans() }}</span>
                                                </div>
                                                <img class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300" src="{{ $message->user->getFilamentAvatarUrl() }}" alt="">
                                            </div>
                                        @else
                                        <div class="flex w-full mt-2 space-x-3 max-w-xs">
                                            <img class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300" src="{{ $message->user->getFilamentAvatarUrl() }}" alt="">
                                            <div>
                                                <div class="bg-gray-300 p-3 rounded-r-lg rounded-bl-lg">
                                                    <p class="text-sm dark:text-black break-words" style="overflow-wrap: anywhere">{!! $this->escapeTags($message->message) !!}</p>
                                                </div>
                                                <span class="text-xs text-gray-500 leading-none">{{ $message->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    @empty
                                        
                                    @endforelse
                                    

                                </div>
                            </div>
                        </div>
                    @endif
                    @if($this->showInboxContainer)
                    <div class="relative max-w-[340px] bg-white shadow-lg rounded-lg">
                    <!-- Card body -->
                    <div class="py-3 px-5">
                        <h3 class="text-xs font-semibold uppercase text-gray-400 mb-1">Chats ({{ count($this->conversations) }})</h3>
                        <!-- Chat list -->
                        <div class="divide-y divide-gray-200">
                            @forelse ($this->conversations as $conversation)
                                <button wire:click="showConversation({{ $conversation->id }})"
                                    class="w-full text-left py-2 focus:outline-none focus-visible:bg-indigo-50">
                                    <div class="flex items-center">
                                        <img class="mr-3 flex-shrink-0 h-10 w-10 rounded-full bg-gray-300"
                                             src="{{ $this->conversationInfos($conversation)?->img }}"
                                             width="32" height="32" alt="{{ $this->conversationInfos($conversation)?->name }}" />
                                        <div class="dark:text-black">
                                            <h4 class="text-sm font-semibold text-gray-900">{{ $this->conversationInfos($conversation)?->name }}</h4>
                                            <div class="text-[13px] break-words" style="overflow-wrap: anywhere">
                                            @if($conversation->receiver == auth()->user()->id && $conversation->is_read == 0) <span class="text-green-500 text-lg">•</span> @endif
                                            {{ Str::limit(strip_tags($conversation?->lastMessage?->message), 22) }} · <small>{{ $conversation?->lastMessage?->created_at->diffForHumans() }}</small></div>
                                        </div>
                                    </div>
                                </button>
                            @empty
                                <div class="text-center py-4 text-gray-400">No chats found</div>
                            @endforelse
                        </div>
                    </div>
                </div> 
                   @if (count($this->conversations) > 9)
                    <div class="relative mx-auto max-w-[80px]">
                        <button wire:click="loadMoreConversations"
                            class="inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                            <svg class="w-5 h-5 text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12H15" stroke="#a5b4fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 9L12 15" stroke="#a5b4fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 12C3 4.5885 4.5885 3 12 3C19.4115 3 21 4.5885 21 12C21 19.4115 19.4115 21 12 21C4.5885 21 3 19.4115 3 12Z" stroke="#a5b4fc" stroke-width="2"/>
                            </svg>
                            <span>{{ __('all.load_more')}}</span>
                        </button>
                    </div>

                    @endif
                    @endif

                    <x-slot name="footer" style="height: 20px">
                        @if($this->showConversationContainer && $this->currentConversation && $this->messages)
                            <form class="bg-gray-300 dark:bg-inherit p-4 mb-3" wire:submit="replyOnConversation">
                                @csrf
                                <input class="dark:bg-inherit flex items-center h-10 w-full rounded px-3 text-sm" wire:model="data.content" type="text" placeholder="Type your message…">
                            </form>
                        @endif
                        <div class="flex justify-between w-full">
                            @if(!$this->showInboxContainer)
                            <button wire:click="showInbox"
                                class="inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                                <svg class="w-5 h-5 text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="#a5b4fc" d="M19 15V21M19 21L21 19M19 21L17 19M13 19H6.2C5.0799 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2C3 7.0799 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H17.8C18.9201 5 19.4802 5 19.908 5.21799C20.2843 5.40973 20.5903 5.71569 20.782 6.09202C21 6.51984 21 7.0799 21 8.2V11M20.6067 8.26204L15.5499 11.6333C14.2669 12.4886 13.6254 12.9163 12.932 13.0824C12.3192 13.2293 11.6804 13.2293 11.0677 13.0824C10.3743 12.9163 9.73279 12.4886 8.44975 11.6333L3.14746 8.09839" stroke="#a5b4fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ __('all.inbox') }}</span>
                            </button>
                            @endif

                            @if($this->showConversationContainer && $this->currentConversation && $this->messages)
                            <button wire:click="refreshConversation"
                                class="inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                                <svg class="w-5 h-5 text-indigo-300 flex-shrink-0 mx-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 12C3 16.9706 7.02944 21 12 21C14.3051 21 16.4077 20.1334 18 18.7083L21 16M21 12C21 7.02944 16.9706 3 12 3C9.69494 3 7.59227 3.86656 6 5.29168L3 8M21 21V16M21 16H16M3 3V8M3 8H8" stroke="#a5b4fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            @endif


                            @if($this->showInboxContainer)
                            <button wire:click="refreshConversations"
                                class="inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                                <svg class="w-5 h-5 text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 12C3 16.9706 7.02944 21 12 21C14.3051 21 16.4077 20.1334 18 18.7083L21 16M21 12C21 7.02944 16.9706 3 12 3C9.69494 3 7.59227 3.86656 6 5.29168L3 8M21 21V16M21 16H16M3 3V8M3 8H8" stroke="#a5b4fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ __('all.refresh')}}</span>
                            </button>
                            @endif

                            @if(!$this->newChat)
                            <button wire:click="startChat" 
                                    class="inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                                <svg class="w-5 h-5 text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.85113 3 4 5.73396 4 10C4 11.5704 4.38842 12.7289 5.08252 13.6554C5.79003 14.5998 6.87746 15.3863 8.41627 16.0908L9.2326 16.4645L8.94868 17.3162C8.54129 18.5384 7.84997 19.6611 7.15156 20.5844C9.56467 19.8263 12.7167 18.6537 14.9453 17.1679C17.1551 15.6948 18.3969 14.5353 19.0991 13.455C19.7758 12.4139 20 11.371 20 10C20 5.73396 16.1489 3 12 3ZM2 10C2 4.26604 7.14887 1 12 1C16.8511 1 22 4.26604 22 10C22 11.629 21.7242 13.0861 20.7759 14.545C19.8531 15.9647 18.3449 17.3052 16.0547 18.8321C13.0781 20.8164 8.76589 22.2232 6.29772 22.9281C5.48665 23.1597 4.84055 22.6838 4.56243 22.1881C4.28848 21.6998 4.22087 20.9454 4.74413 20.3614C5.44439 19.5798 6.21203 18.5732 6.72616 17.4871C5.40034 16.7841 4.29326 15.9376 3.48189 14.8545C2.48785 13.5277 2 11.9296 2 10Z" fill="#a5b4fc"/>
                                    <path d="M12 6C11.4477 6 11 6.44771 11 7V9H9C8.44772 9 8 9.44771 8 10C8 10.5523 8.44772 11 9 11H11V13C11 13.5523 11.4477 14 12 14C12.5523 14 13 13.5523 13 13V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H13V7C13 6.44771 12.5523 6 12 6Z" fill="#a5b4fc"/>
                                </svg>
                                <span>New Chat</span>
                            </button>
                            @else
                                <button wire:click="createNewConversation" 
                                    class="inline-flex text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center  px-3 py-2 focus:outline-none focus-visible:ring-2">
                                    <svg class="w-3 h-3 fill-current text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 12 12">
                                        <path d="M11.866.146a.5.5 0 0 0-.437-.139c-.26.044-6.393 1.1-8.2 2.913a4.145 4.145 0 0 0-.617 5.062L.305 10.293a1 1 0 1 0 1.414 1.414L7.426 6l-2 3.923c.242.048.487.074.733.077a4.122 4.122 0 0 0 2.933-1.215c1.81-1.809 2.87-7.94 2.913-8.2a.5.5 0 0 0-.139-.439Z" />
                                    </svg>
                                    <span>Start Conversation</span>
                                </button>
                            @endif
                        </div>
                    </x-slot>


            </x-filament::modal>




    </div>
</div>

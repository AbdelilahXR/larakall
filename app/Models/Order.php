<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;



class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'reference',
        'name',
        'client',
        'phone',
        'price',
        'city',
        'adress',
        'information',
        'stores_id',
        'companies_id'
    ];

    protected $casts = [
        'price' => 'float'
    ];


    public function users(): HasMany
    {
        return $this->hasMany(OrderUser::class, 'orders_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'orders_id');
    }

    public function productDetail()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderProduct::class,
            'orders_id',
            'id',
            'id',
            'products_id'
        );
    }

    public function orderProducts()
    {
        return $this->belongsToMany(Product::class, 'orders_products', 'orders_id', 'products_id')->withPivot('quantity', 'unit_price');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'stores_id');
    }


    public function company()
    {
        return $this->belongsTo(Company::class, 'companies_id');
    }

    public function lastConfirmationState()
    {
        return $this->hasOneThrough(
            State::class,
            StateOrder::class,
            'orders_id',
            'id',
            'id',
            'states_id'
        )->where('type', 'confirmation')->latest('states_orders.created_at');
    }
    

    public function lastDeliveryState()
    {
        return $this->hasOneThrough(
            State::class,
            StateOrder::class,
            'orders_id',
            'id',
            'id',
            'states_id'
        )->where('type', 'delivery')->latest('states_orders.created_at');
    }


    public function states()
    {
        return $this->hasMany(StateOrder::class, 'orders_id');
    }


    public function scopeWithLastConfirmationState($query, $stateName)
    {
        return $query->where('confirmation_state', function ($query) use ($stateName) {
            $query->select('id')
                ->from('states')
                ->where('name', $stateName)
                ->where('type', 'confirmation');
        });
    }

    public function scopeWithLastDeliveryState($query, $stateName)
    {
        return $query->where('delivery_state', function ($query) use ($stateName) {
            $query->select('id')
                ->from('states')
                ->where('name', $stateName)
                ->where('type', 'delivery');
        });
    }


    public function scopeFilterByUser($query)
    {
        if (auth()->user()->hasRole('super_admin')) {
            return $query;
        }

        return $query->whereHas('users', function ($query) {
            $query->where('users_id', auth()->user()->id);
        });
    }

    public function scopeFilterByStore($query, $store)
    {
        if ($store == '') {
            return $query;
        }
        return $query->where('stores_id', $store);
    }

    // filter by date range
    public function scopeFilterByDateRange($query, $from, $to)
    {
        if ($from == null && $to == null) {
            return $query->whereDate('created_at', now()->toDateString());
        } elseif ($from == null) {
            return $query->where('created_at', '<=', $to);
        } elseif ($to == null) {
            return $query->where('created_at', '>=', $from);
        }
        return $query->whereBetween('created_at', [$from, $to]);
    }


    protected static function booted()
    {
        static::created(function ($order) {

            $status = State::where('name', 'New')->where('type', 'confirmation')->first();
            if ($status) {
                if ($status->color != '#007aff') {
                    $status->color = '#007aff';
                    $status->save();
                }
            }

            if (!$status) {
                $status = State::firstOrCreate(['name' => 'New', 'color' => '#007aff', 'type' => 'confirmation']);
            }

            $stateOrder = new StateOrder();
            $stateOrder->users_id = auth()->user()->id;
            $stateOrder->states_id = $status->id;
            $stateOrder->orders_id = $order->id;
            $stateOrder->created_at = now();
            $stateOrder->save();

            $order->confirmation_state = $status->id;
            $order->save();
                        

            $orderUser = new OrderUser();
            $orderUser->users_id = $order->store->user->id;
            $orderUser->orders_id = $order->id;
            $orderUser->created_at = now();
            $orderUser->save();

            /**
             * Title: dispatch order over agents
             * Description: Add new order to agents who don't have this order or have it but in new state
             */

            $agents = User::whereHas('roles', function ($query) {
                $query->where('name', 'agent');
            })->get();
            
            $lessAgent = $agents->sortBy(function ($agent) {
                return $agent->orders()->withLastConfirmationState('New')->count();
            })->first();

            $lessAgent->orders()->attach($order->id);
        });
    }


    
}

<x-filament::modal width="4xl" id="test-modal">
    <x-slot name="trigger">
        <div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
            @forelse ($this->orderProducts->take(2) as $product)
            
                <div class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white">
                    {{ Str::limit($product->products?->name, 13) }}
                </div>

            @empty
                {{ __('all.no_products') }}
            @endforelse
        </div>
    </x-slot>
 
    <x-slot name="heading">
        {{ __('all.products') }} #{{ $this->order->code }}
    </x-slot>

        <div>
            <table class="min-w-full divide-y divide-gray-200" width="100%">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('all.product_name') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('all.product_variant') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('all.quantity') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('all.unit_price') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('all.total') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($this->orderProducts as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($product->products?->type == 'simple')
                                    {{ $product->products?->name }}
                                @endif
                                @if($product->products?->type == 'variant')
                                    {{ $this->getParentProduct($product->products?->parent_id) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($product->products?->type == 'simple')
                                    {{ __('all.default') }}
                                @endif
                                @if($product->products?->type == 'variant')
                                    {{ $product->products?->name }}
                                @endif
                            </td>                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $product->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $product->unit_price }} MAD
                                <div><small>Min. {{ $product->products?->min_price }} MAD - Max. {{ $product->products?->max_price }} MAD*</small></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $product->quantity * $product->unit_price }} MAD
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center">
                                {{ __('all.no_products') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-right font-medium text-sm">
                            <b>{{ __('all.total') }}</b>
                            <div class="text-lg">{{ $this->orderProducts->sum(function ($product) {
                                return $product->quantity * $product->unit_price;
                            }) }} MAD</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <small>* {{ __('all.min_max_price_in_store_of_this_platform') }}</small>
</x-filament::modal>
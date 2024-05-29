<?php

namespace App\Filament\Imports;

use App\Models\Order;
use App\Models\Product;

use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use App\Helpers\OrderHelper;
use Illuminate\Support\Facades\Validator;

class OrderImporter extends Importer
{
    protected static ?string $model = Order::class;

    public static  $used = [];
    public static  $successOrders = 0;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('reference')
                ->requiredMapping()
                ->rules(['required', 'max:45']),
            ImportColumn::make('client')
                ->requiredMapping()
                ->rules(['required', 'max:45']),
            ImportColumn::make('phone')
                ->requiredMapping()
                ->rules(['required', 'max:45']),
            ImportColumn::make('city')
                ->requiredMapping()
                ->rules(['required', 'max:45']),
            ImportColumn::make('adress')
                ->label('Address')
                ->rules(['required', 'max:190']),
            ImportColumn::make('tracking_code')
                ->rules(['required','max:50']),
            ImportColumn::make('information')
                ->rules(['max:500']),
            ImportColumn::make('product_name')
                ->requiredMapping()
                ->rules(['required','max:250']),
            ImportColumn::make('product_variant')
                ->rules(['required','max:250']),
            ImportColumn::make('quantity')
                ->requiredMapping()
                ->rules(['required','max:45']),
            ImportColumn::make('unit_price')
                ->requiredMapping()
                ->rules(['required','max:45']),
        ];
    }

    public function resolveRecord(): ?Order
    {

        $validator = validator($this->data, [
            'reference' => 'required|max:45',
            'client' => 'required|max:100',
            'phone' => 'required|max:45',
            'city' => 'required|max:45',
            'adress' => 'max:190',
            'information' => 'max:500',
            'tracking_code' => 'max:50',
            'product_name' => 'required|max:255',
            'product_variant' => 'max:255',
            'quantity' => 'required|digits_between:1,10',
            'unit_price' => 'required|numeric|between:0.01,999999999.99',
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return null;
        }

        
        if (@$this->data['product_variant'] == 'default' || !isset($this->data['product_variant'])) {
            $product = Product::where('name', $this->data['product_name'])->
                                where('stores_id', $this->options['store_id'])->
                                where('type', 'simple')->first();
        }
        elseif (@$this->data['product_variant'] != ''){
            $product_name = $this->data['product_name'];
            $product = Product::where('name', $this->data['product_variant'])->
                                where('stores_id', $this->options['store_id'])->
                                whereHas('parentProduct', function ($query) use ($product_name) {
                                            $query->where('name', $product_name);
                                        })->first();
        }
        else {
            $product = null;
        }
        

        $checkOrder = Order::where('reference', $this->data['reference'])->
                            where('stores_id', $this->options['store_id'])->
                            with('products')->
                            first();

         if (in_array($this->data['reference'], self::$used) && !$product)
            {
                $checkOrder->orderProducts()->detach();
                $checkOrder->delete();
                self::$successOrders--;
                dd('Product not found');
            }

        if (!$product && !in_array($this->data['reference'], self::$used)) {
            return null;
        }


        $this->data['phone'] = OrderHelper::formatPhoneNumber($this->data['phone']);


        if ($checkOrder) {



            
            if (!in_array($this->data['reference'], self::$used))
            {
                $checkOrder->orderProducts()->detach();
                self::$successOrders++;
            }

            $checkOrder->orderProducts()->attach($product->id, [
                'quantity' => $this->data['quantity'] ?? 0,
                'unit_price' => $this->data['unit_price'] ?? 0.00,
            ]);

            $checkOrder->update([
                'client' => $this->data['client'] ?? '',
                'phone' => $this->data['phone'] ?? '',
                'city' => $this->data['city'] ?? '',
                'adress' => $this->data['adress'] ?? '',
                'information' => $this->data['information'] ?? '',
                'price' => ($checkOrder->price + ($this->data['unit_price'] * $this->data['quantity'])) ?? 0.00,
            ]);

            self::$used[] = $this->data['reference'];
            return null;

        }
        else {

            $order = Order::create([
                'code' => OrderHelper::generateReference(),
                'reference' => $this->data['reference'] ?? '',
                'client' => $this->data['client'] ?? '',
                'phone' => $this->data['phone'] ?? '',
                'price' => $this->data['unit_price'] ?? 0.00,
                'city' => $this->data['city'] ?? '',
                'adress' => $this->data['adress'] ?? '',
                'information' => $this->data['information'] ?? '',
                'stores_id' => $this->options['store_id'],
            ]);


            $order->orderProducts()->attach($product->id, [
                'quantity' => $this->data['quantity'] ?? 0,
                'unit_price' => $this->data['unit_price'] ?? 0,
            ]);

            
            self::$successOrders++;
            self::$used[] = $this->data['reference'];
            return null;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your order import has completed and ' . number_format(self::$successOrders) . ' ' . str('row')->plural(self::$successOrders) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

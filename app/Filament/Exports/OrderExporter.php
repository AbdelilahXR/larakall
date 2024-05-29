<?php

namespace App\Filament\Exports;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;



class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;


    public function __invoke(Model $record): array
    {
        $this->record = $record;

        $columns = $this->getCachedColumns();

        $data = [];

        $orderProduct = OrderProduct::where('id', $record->id)->first();

        if (!$orderProduct) {
            return $data;
        }

        $product = Product::where('id', $orderProduct->products_id)->with('parentProduct')->first();

        if (!$product) {
            return $data;
        }

        $order = Order::where('id', $orderProduct->orders_id)->with('store')->first();

        if (!$order) {
            return $data;
        }

        if ($product->parentProduct) {
            $product_name = $product->parentProduct->name;
            $product_variant = $product->name;
        } else {
            $product_name = $product->name;
            $product_variant = 'default';
        }

        foreach (array_keys($this->columnMap) as $column) {
            
            if ($column == 'reference') {
                $data[] = $order->reference;
            }

            elseif ($column == 'client') {
                $data[] = $order->client;
            }

            elseif ($column == 'phone') {
                $data[] = $order->phone;
            }

            elseif ($column == 'price') {
                $data[] = $order->price;
            }

            elseif ($column == 'city') {
                $data[] = $order->city;
            }

            elseif ($column == 'adress') {
                $data[] = $order->adress;
            }

            elseif ($column == 'information') {
                $data[] = $order->information;
            }

            elseif ($column == 'product_name') {
                $data[] = $product_name;
            }

            elseif ($column == 'product_variant') {
                $data[] = $product_variant;
            }

            elseif ($column == 'unit_price') {
                $data[] = $orderProduct->unit_price;
            }

            elseif ($column == 'quantity') {
                $data[] = $orderProduct->quantity;
            }

            elseif ($column == 'store') {
                $data[] = $order?->store?->name;
            }

            else {
                $data[] = null;
            }
        }
        return $data;
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('reference'),
            ExportColumn::make('client'),
            ExportColumn::make('phone'),
            ExportColumn::make('price'),
            ExportColumn::make('city'),
            ExportColumn::make('adress'),
            ExportColumn::make('tracking_code'),
            ExportColumn::make('information'),
            ExportColumn::make('product_name'),
            ExportColumn::make('product_variant'),
            ExportColumn::make('quantity'),
            ExportColumn::make('unit_price'),
            ExportColumn::make('store'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {        
        $body = 'Your order export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

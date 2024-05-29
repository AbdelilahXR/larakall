<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\OrderHelper;

class ImportGoogleSheetService
{
    public $importType;

    public function HandleImport($dataSheet, $matched_columns, $store_id)
    {
        $db_columns = (object) $matched_columns;

        $dataSheet[0][$db_columns->phone] = OrderHelper::formatPhoneNumber($dataSheet[0][$db_columns->phone]);

        $validate_columns = Validator::make($dataSheet[0], [
            $db_columns->reference => 'required|string',
            $db_columns->client => 'required|string',
            $db_columns->phone => 'required|numeric',
            $db_columns->city => 'required|string',
            $db_columns->adress => 'string',
            $db_columns->information => 'required|string',
            $db_columns->tracking_code => 'string',
        ]);

        if($validate_columns->fails()){
            
            return [
                'status' => 'error',
                'errors' => [
                    'order' => $dataSheet[0][$db_columns->reference],
                    'error' => $validate_columns->errors()->all()
                ]
                
            ];
        }

        $checkProductsResult = $this->checkProducts($dataSheet, $db_columns, $store_id);

        if ($checkProductsResult['success'] == false) {
            return [
                'status' => 'error',
                'errors' => [
                    'order' => $dataSheet[0][$db_columns->reference],
                    'error' => $checkProductsResult['errors']
                ]
                
            ];
        }
        else 
        {
            $order = Order::where('reference', $dataSheet[0][$db_columns->reference])->where('stores_id', $store_id)->first();

            if ($order) {   

                $order->orderProducts()->detach();

                $order->client = $dataSheet[0][$db_columns->client] ?? null;
                $order->phone = $dataSheet[0][$db_columns->phone] ?? null;
                $order->price = $checkProductsResult['total_price'] ?? null;
                $order->city = $dataSheet[0][$db_columns->city] ?? null;
                $order->adress = $dataSheet[0][$db_columns->adress] ?? null;
                $order->information = $dataSheet[0][$db_columns->information] ?? null;
                $order->tracking_code = $dataSheet[0][$db_columns->tracking_code] ?? null;
                $order->stores_id = $store_id;
                $order->save();
                
                $this->importType = 'update';
            }
            else {
                $order = new Order();
                $order->code = OrderHelper::generateReference();
                $order->reference = $dataSheet[0][$db_columns->reference] ?? null;
                $order->client = $dataSheet[0][$db_columns->client] ?? null;
                $order->phone = $dataSheet[0][$db_columns->phone] ?? null;
                $order->price = $checkProductsResult['total_price'] ?? 0;
                $order->city = $dataSheet[0][$db_columns->city] ?? null;
                $order->adress = $dataSheet[0][$db_columns->adress] ?? null;
                $order->information = $dataSheet[0][$db_columns->information] ?? null;
                $order->tracking_code = $dataSheet[0][$db_columns->tracking_code] ?? null;
                $order->stores_id = $store_id;
                $order->save();

                $this->importType = 'insert';
            }
        }

        if($this->attachProducts($dataSheet, $db_columns, $order))
        {
            return [
                'status' => 'success',
                'order' => $dataSheet[0][$db_columns->reference],
                'type' => $this->importType
            ];
        }
        else
        {
            return [
                'status' => 'error',
                'order' => $dataSheet[0][$db_columns->reference],
                'error' => __('all.error_attach_products')
            ];
        }

        
    }


    public function checkProducts($dataSheet, $db_columns, $store_id){

        $result = [
            'success' => false,
            'errors' => [],
            'total_price' => 0
        ];


        foreach ($dataSheet as $key => $value) {

            $validate_columns = Validator::make($value, [
                $db_columns->price => 'required|numeric',
                $db_columns->product_variant => 'string',
                $db_columns->total_quantity => 'required|numeric',
                $db_columns->product_name => 'required|string',
                $db_columns->sku => 'string',
            ]);

            if($validate_columns->fails()){
                $result['errors'][] = $validate_columns->errors();
                return $result;       
            }

            if (@$value[$db_columns->product_variant] == "default" || !isset($value[$db_columns->product_variant])) {
                if (!Product::where('name', $value[$db_columns->product_name])->where('stores_id', $store_id)->where('type', 'simple')->first())
                {
                    $result['errors'][] = __('all.product_not_found');
                    return $result;
                }
            }
            elseif (@$value[$db_columns->product_variant] != "")
            {
                if (!Product::where('name', $value[$db_columns->product_name])->where('stores_id', $store_id)->whereHas('variants', function ($query) use ($db_columns, $value) {
                    $query->where('name', $value[$db_columns->product_variant]);
                    })->first()) 
                {
                    $result['errors'][] = __('all.product_variant_not_found');
                    return $result; 
                }
            }
            else {
                $result['errors'][] = __('all.product_variant_not_found');
                return $result; 
            }

            $result['total_price'] += $value[$db_columns->price] * $value[$db_columns->total_quantity];
        }

        $result['success'] = true;
        
        return $result;
 
    }


    public function attachProducts($dataSheet, $db_columns, $order)
    {
        foreach($dataSheet as $key => $value)
        {
            if (@$value[$db_columns->product_variant] == "default" || !isset($value[$db_columns->product_variant])) {

                $product = Product::where('name', $value[$db_columns->product_name])->where('type', 'simple')->first();

                $order->orderProducts()->attach($product->id, [
                    'quantity' => $value[$db_columns->total_quantity] ?? 0,
                    'unit_price' => $value[$db_columns->price] ?? 0,
                ]);
            }
            else
            {
                $product = Product::where('name', $value[$db_columns->product_variant])->whereHas('parentProduct', function ($query) use ($db_columns, $value) {
                    $query->where('name', $value[$db_columns->product_name]);
                })->first();

                $order->orderProducts()->attach($product->id, [
                    'quantity' => $value[$db_columns->total_quantity] ?? 0,
                    'unit_price' => $value[$db_columns->price] ?? 0,
                ]);
            }
        }

        return true;
    }


}
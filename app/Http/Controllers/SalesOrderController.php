<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder as ModelsSalesOrder;
use App\Models\SalesStyle as ModelsSalesStyle;
use App\Models\ColorMethodSalesStyle as ModelsColorMethodSalesStyle;
use App\Models\ColorNameSalesStyle as ModelsColorNameSalesStyle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function index()
    {
        $sales = ModelsSalesOrder::all();

        return response()->json(['data' => $sales], Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        try {
            Log::info('Request Data: ' . json_encode($request->all()));

            $jsonContent = $request->json()->all();
            $validatedData = $this->validate($request, [
                'sonumber' => 'required|max:5',
                'customer' => 'required|max:15',
                'date' => 'required|max:15'
            ]);

            $post = new ModelsSalesOrder([
                'sonumber' => $validatedData['sonumber'],
                'customer' => $validatedData['customer'],
                'date' => $validatedData['date'],
            ]);

            $post->save();

            return response()->json(['message' => 'Sales order created successfully', 'data' => $post], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create sales order', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $post = ModelsSalesOrder::findOrFail($id);

            $validatedData = $this->validate($request, [
                'sonumber' => 'required|max:5',
                'customer' => 'required|max:15',
                'date' => 'required|max:15'
            ]);

            $post->update([
                'sonumber' => $validatedData['sonumber'],
                'customer' => $validatedData['customer'],
                'date' => $validatedData['date'],
            ]);

            return response()->json(['message' => 'Sales order updated successfully', 'data' => $post], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error updating sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to update sales order', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $post = ModelsSalesOrder::findOrFail($id);
            $post->delete();

            return response()->json(['message' => 'Sales order deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error deleting sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to delete sales order', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $post = ModelsSalesOrder::findOrFail($id);

            return response()->json(['data' => $post], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error retrieving sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Sales order not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }


    public function transformSalesOrder($salesOrderData)
    {
        $transformedData = [];

        foreach ($salesOrderData as $item) {
            $soNumber = $item->sonumber;

            if (!isset($transformedData[$soNumber])) {
                $transformedData[$soNumber] = [
                    'soNumber' => $soNumber,
                    'namaCustomer' => $item->customer,
                    'date' => $item->date,
                    'data' => [],
                ];
            }

            $styleId = $item->style_id;
            $colorMethodId = $item->color_method_id;

            $styleIndex = null;
            foreach ($transformedData[$soNumber]['data'] as $index => $style) {
                if ($style['id'] == $styleId) {
                    $styleIndex = $index;
                    break;
                }
            }

            if ($styleIndex === null) {
                $transformedData[$soNumber]['data'][] = [
                    'id' => $styleId,
                    'name_style' => $item->style_name,
                    'desc' => $item->desc,
                    'qty' => 0,
                    'row' => [],
                ];
                $styleIndex = count($transformedData[$soNumber]['data']) - 1;
            }

            $transformedData[$soNumber]['data'][$styleIndex]['qty'] += $item->qty;

            $transformedData[$soNumber]['data'][$styleIndex]['row'][] = [
                'id' => $colorMethodId,
                'name' => $item->color_method_name,
                'desc' => $item->color_method_desc,
                'isSelected' => true,
                'colorName' => [
                    [
                        'id' => $item->color_name_id,
                        'name' => $item->color_name,
                        'color_method_id' => $item->color_method_id,
                        'isSelected' => true,
                        'qty' => $item->qty,
                    ],
                ],
            ];
        }

        return array_values($transformedData);
    }



    public function getSalesOrderById($id)
    {
        try {
            $result = ModelsSalesStyle::select(
                'sales_styles.id as sales_style_id',
                'sales_styles.sales_order_id',
                'sales_styles.style_id',
                'color_method_sales_styles.id as color_method_sales_style_id',
                'color_method_sales_styles.color_method_id',
                'color_name_sales_styles.id as color_name_method_id',
                'color_name_sales_styles.color_name_id',
                'styles.style_name',
                'styles.desc',
                'sales_orders.sonumber',
                'sales_orders.customer',
                'sales_orders.date',
                'color_name_sales_styles.qty',
                'color_methods.name as color_method_name',
                'color_methods.desc as color_method_desc',
                'color_name_methods.name as color_name'
            )
                ->leftJoin('sales_orders', 'sales_orders.id', '=', 'sales_styles.sales_order_id')
                ->leftJoin('styles', 'styles.id', '=', 'sales_styles.style_id')
                ->leftJoin('color_method_sales_styles', 'color_method_sales_styles.sales_style_id', '=', 'sales_styles.id')
                ->leftJoin('color_name_sales_styles', 'color_name_sales_styles.colormethod_sales_id', '=', 'color_method_sales_styles.id')
                ->leftJoin('color_methods', 'color_methods.id', '=', 'color_method_sales_styles.color_method_id')
                ->leftJoin('color_name_methods', 'color_name_methods.id', '=', 'color_name_sales_styles.color_name_id')
                ->where('sales_orders.id', $id)
                ->get();

            $transformedData = $this->transformSalesOrder($result);

            return response()->json(['data' => $transformedData], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error retrieving sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Cannot create Sales Order', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function deleteSales($id)
    {
        try {
            DB::beginTransaction();

            $salesOrder = ModelsSalesOrder::findOrFail($id);

            ModelsColorNameSalesStyle::whereIn(
                'colormethod_sales_id',
                ModelsColorMethodSalesStyle::whereIn(
                    'sales_style_id',
                    $salesOrder->salesStyles()->pluck('id')->toArray()
                )->pluck('id')->toArray()
            )->delete();

            ModelsColorMethodSalesStyle::whereIn(
                'sales_style_id',
                $salesOrder->salesStyles()->pluck('id')->toArray()
            )->delete();

            $salesOrder->salesStyles()->delete();

            $salesOrder->delete();

            DB::commit();

            return response()->json(
                [
                    "message" => "Success deleting Sales Order",
                    "success" => true,
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Cannot delete Sales Order', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function createSales(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Request Data: ' . json_encode($request->all()));
            $body = json_decode($request->getContent());
            $countData = count($body->data);
            $data = [];
            // $asd= '';
            if (isset($body->soNumber) && isset($body->namaCustomer) && isset($body->date) && isset($body->data) && is_array($body->data)) {
                $postSalesOrder = new ModelsSalesOrder([
                    'sonumber' => $body->soNumber,
                    'customer' =>  $body->namaCustomer,
                    'date' => $body->date
                ]);
                $postSalesOrder->save();
                $countData = count($body->data);

                for ($i = 0; $i < $countData; $i++) {
                    array_push($data, $body->data[$i]);
                    $postSalesStyle = new ModelsSalesStyle([
                        'sales_order_id' => $postSalesOrder->id,
                        'style_id' => $data[$i]->id,
                        'qty' => $data[$i]->qty

                    ]);
                    $postSalesStyle->save();
                    $countData2 = count($data[$i]->row);
                    for ($l = 0; $l < $countData2; $l++) {
                        $postColorMethodSalesStyle = new ModelsColorMethodSalesStyle([
                            'sales_style_id' => $postSalesStyle->id,
                            'color_method_id' => $data[$i]->row[$l]->id
                        ]);
                        $postColorMethodSalesStyle->save();
                        $postColorNameSalesStyle = new ModelsColorNameSalesStyle([
                            'colormethod_sales_id' => $postColorMethodSalesStyle->id,
                            'color_name_id' => $data[$i]->row[$l]->colorName[0]->id,
                            'qty' => $data[$i]->row[$l]->colorName[0]->qty
                        ]);

                        $postColorNameSalesStyle->save();
                    }
                }
            } else {
                return response()->json(['error' => 'Invalid data format'], Response::HTTP_BAD_REQUEST);
            }
            DB::commit();




            return response()->json(
                [
                    "message" => "Success Menambahkan Sales Order",
                    "success" => true,
                    "data" => $body
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error retrieving sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Cannot create Sales Order', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function updateSales(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            Log::info('Request Data: ' . json_encode($request->all()));
            $body = json_decode($request->getContent());

            $salesOrder = ModelsSalesOrder::findOrFail($id);

            $salesOrder->sonumber = $body->soNumber;
            $salesOrder->customer = $body->namaCustomer;
            $salesOrder->date = $body->date;
            $salesOrder->save();

            $salesOrder->salesStyles()->delete();

            foreach ($body->data as $styleData) {
                $salesStyle = ModelsSalesStyle::updateOrCreate(
                    ['sales_order_id' => $salesOrder->id, 'style_id' => $styleData->id],
                    ['qty' => $styleData->qty]
                );

                $salesStyle->colorMethodSalesStyles()->delete();

                foreach ($styleData->row as $colorMethod) {
                    $colorMethodSalesStyle = ModelsColorMethodSalesStyle::updateOrCreate(
                        ['sales_style_id' => $salesStyle->id, 'color_method_id' => $colorMethod->id]
                    );

                    ModelsColorNameSalesStyle::updateOrCreate(
                        ['colormethod_sales_id' => $colorMethodSalesStyle->id],
                        [
                            'color_name_id' => $colorMethod->colorName[0]->id,
                            'qty' => $colorMethod->colorName[0]->qty
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json(
                [
                    "message" => "Success updating Sales Order",
                    "success" => true,
                    "data" => $body
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating sales order: ' . $e->getMessage());

            return response()->json(['error' => 'Cannot update Sales Order', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SalesStyle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class SalesStyleController extends Controller
{
    public function index()
    {
        $salesStyles = SalesStyle::all();

        return response()->json(['data' => $salesStyles], Response::HTTP_OK);
    }

    public function show($id)
    {
        $salesStyle = SalesStyle::findOrFail($id);

        return response()->json(['data' => $salesStyle], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'sales_order_id' => 'required|exists:sales_orders,id',
            'style_id' => 'required|exists:styles,id',
            'qty' => 'required|integer',
        ]);

        $salesStyle = SalesStyle::create($validatedData);

        return response()->json(['data' => $salesStyle], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $salesStyle = SalesStyle::findOrFail($id);

        $validatedData = $this->validate($request, [
            'sales_order_id' => 'exists:sales_orders,id',
            'style_id' => 'exists:styles,id',
            'qty' => 'integer',
        ]);

        $salesStyle->update($validatedData);

        return response()->json(['data' => $salesStyle], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $salesStyle = SalesStyle::findOrFail($id);
        $salesStyle->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function joinSOandStyle()
    {
        try {
            $result = SalesStyle::select('sales_styles.*', 'styles.style_name', 'styles.desc', 'sales_orders.sonumber', 'sales_orders.customer', 'sales_orders.date')
                ->leftJoin('sales_orders', 'sales_orders.id', '=', 'sales_styles.sales_order_id')
                ->leftJoin('styles', 'styles.id', '=', 'sales_styles.style_id')
                ->get();

            $groupedData = collect($result)->groupBy('sales_order_id');

            $results = [];

            foreach ($groupedData as $styleId => $styleData) {
                $sumQty = $styleData->sum('qty');
                $firstItem = $styleData->first();
                unset($firstItem['style_id']);
                $firstItem['qty'] = $sumQty;
                $results[] = $firstItem;
            }

            return response()->json(['data' => $results, 'message' => 'successfully getData'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error creating style: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create style', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

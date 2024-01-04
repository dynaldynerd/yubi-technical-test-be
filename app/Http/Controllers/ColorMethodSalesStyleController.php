<?php
// app/Http/Controllers/ColorMethodSalesStyleController.php

namespace App\Http\Controllers;

use App\Models\ColorMethodSalesStyle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ColorMethodSalesStyleController extends Controller
{
    public function index()
    {
        // $colorMethodSalesStyles = ColorMethodSalesStyle::with('sales_style', 'color_method')->get();
        $test = DB::table('color_method_sales_styles')
            ->leftJoin('color_methods', 'color_method_sales_styles.color_method_id', '=', 'color_methods.id')
            ->leftJoin('sales_styles', 'color_method_sales_styles.sales_style_id', '=', 'sales_styles.id')
            ->leftJoin('styles', 'sales_styles.style_id', '=', 'styles.id')
            ->select('color_method_sales_styles.*', 'styles.style_name as style_name', 'styles.desc as style_desc', 'color_methods.name as color_method_name', 'color_methods.desc as color_method_desc', 'sales_styles.*')
            ->get();

        return response()->json(['data' => $test], Response::HTTP_OK);
    }

    public function show($id)
    {
        $colorMethodSalesStyle = ColorMethodSalesStyle::findOrFail($id);

        return response()->json(['data' => $colorMethodSalesStyle], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'sales_style_id' => 'required|exists:sales_styles,id',
            'color_method_id' => 'required|exists:color_methods,id',
        ]);

        $colorMethodSalesStyle = ColorMethodSalesStyle::create($validatedData);

        return response()->json(['data' => $colorMethodSalesStyle], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $colorMethodSalesStyle = ColorMethodSalesStyle::findOrFail($id);

        $validatedData = $this->validate($request, [
            'sales_style_id' => 'exists:sales_styles,id',
            'color_method_id' => 'exists:color_methods,id',
        ]);

        $colorMethodSalesStyle->update($validatedData);

        return response()->json(['data' => $colorMethodSalesStyle], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $colorMethodSalesStyle = ColorMethodSalesStyle::findOrFail($id);
        $colorMethodSalesStyle->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

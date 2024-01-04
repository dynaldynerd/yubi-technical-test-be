<?php

namespace App\Http\Controllers;

use App\Models\ColorNameSalesStyle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ColorNameSalesStyleController extends Controller
{
    public function index()
    {
        $colorNameSalesStyles = ColorNameSalesStyle::all();

        return response()->json(['data' => $colorNameSalesStyles], Response::HTTP_OK);
    }

    public function show($id)
    {
        $colorNameSalesStyle = ColorNameSalesStyle::findOrFail($id);

        return response()->json(['data' => $colorNameSalesStyle], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'colormethod_sales_id' => 'required|exists:color_method_sales_styles,id',
            'color_name_id' => 'required|exists:color_name_methods,id',
            'qty' => 'required|integer',
        ]);

        $colorNameSalesStyle = ColorNameSalesStyle::create($validatedData);

        return response()->json(['data' => $colorNameSalesStyle], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $colorNameSalesStyle = ColorNameSalesStyle::findOrFail($id);

        $validatedData = $this->validate($request, [
            'colormethod_sales_id' => 'exists:color_method_sales_styles,id',
            'color_name_id' => 'exists:color_name_methods,id',
            'qty' => 'integer',
        ]);

        $colorNameSalesStyle->update($validatedData);

        return response()->json(['data' => $colorNameSalesStyle], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $colorNameSalesStyle = ColorNameSalesStyle::findOrFail($id);
        $colorNameSalesStyle->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

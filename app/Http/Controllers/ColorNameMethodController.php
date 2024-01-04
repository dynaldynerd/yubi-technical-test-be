<?php

namespace App\Http\Controllers;

use App\Models\ColorNameMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ColorNameMethodController extends Controller
{
    public function index()
    {
        $colorNameMethods = ColorNameMethod::with('color_method')->get();

        return response()->json(['data' => $colorNameMethods], Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => 'required|max:255',
                'color_method_id' => 'required|exists:color_methods,id',
            ]);

            $colorNameMethod = ColorNameMethod::create($validatedData);

            return response()->json(['data' => $colorNameMethod, 'message' => 'Color Name Method created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error creating color name method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create color name method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $colorNameMethod = ColorNameMethod::findOrFail($id);

            return response()->json(['data' => $colorNameMethod], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error retrieving color name method: ' . $e->getMessage());

            return response()->json(['error' => 'Color name method not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function showByColorMethodId($id)
    {
        try {
            $colors = ColorNameMethod::where('color_method_id', $id)
                ->with('color_method')
                ->get();

            if ($colors->isEmpty()) {
                return response()->json(['error' => 'Color not found for the given color_method_id'], 404);
            }

            return response()->json(['data' => $colors], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving color name method: ' . $e->getMessage());

            return response()->json(['error' => 'Color name method not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $colorNameMethod = ColorNameMethod::findOrFail($id);

            $validatedData = $this->validate($request, [
                'name' => 'required|max:255',
                'color_method_id' => 'required|exists:color_methods,id',
            ]);

            $colorNameMethod->update($validatedData);

            return response()->json(['data' => $colorNameMethod, 'message' => 'Color Name Method updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error updating color name method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to update color name method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $colorNameMethod = ColorNameMethod::findOrFail($id);
            $colorNameMethod->delete();

            return response()->json(['message' => 'Color Name Method deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error deleting color name method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to delete color name method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

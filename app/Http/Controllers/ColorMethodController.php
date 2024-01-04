<?php

namespace App\Http\Controllers;

use App\Models\ColorMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ColorMethodController extends Controller
{
    public function index()
    {
        $colorMethods = ColorMethod::all();

        return response()->json(['data' => $colorMethods], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => 'required|max:255',
                'desc' => 'required',
            ]);

            $colorMethod = ColorMethod::create($validatedData);

            return response()->json(['data' => $colorMethod, 'message' => 'Color Method created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error creating color method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create color method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $colorMethod = ColorMethod::findOrFail($id);

            return response()->json(['data' => $colorMethod], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error retrieving color method: ' . $e->getMessage());

            return response()->json(['error' => 'Color method not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $colorMethod = ColorMethod::findOrFail($id);

            $validatedData = $this->validate($request, [
                'name' => 'required|max:255',
                'desc' => 'required',
            ]);

            $colorMethod->update($validatedData);

            return response()->json(['data' => $colorMethod, 'message' => 'Color Method updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error updating color method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to update color method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $colorMethod = ColorMethod::findOrFail($id);
            $colorMethod->delete();

            return response()->json(['message' => 'Color Method deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error deleting color method: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to delete color method', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

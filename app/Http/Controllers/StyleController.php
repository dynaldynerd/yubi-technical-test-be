<?php

namespace App\Http\Controllers;

use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StyleController extends Controller
{
    public function index()
    {
        $styles = Style::all();
        return response()->json(['data' => $styles], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'style_name' => 'required|max:255',
                'desc' => 'required|max:255',
            ]);

            $style = Style::create($validatedData);

            return response()->json(['message' => 'Style created successfully', 'data' => $style], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error creating style: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create style', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $style = Style::findOrFail($id);

            $validatedData = $this->validate($request, [
                'style_name' => 'required|max:255',
                'desc' => 'required|max:255',
            ]);

            $style->update($validatedData);

            return response()->json(['message' => 'Style updated successfully', 'data' => $style], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error updating style: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to update style', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $style = Style::findOrFail($id);
            $style->delete();

            return response()->json(['message' => 'Style deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error deleting style: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to delete style', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $style = Style::findOrFail($id);

            return response()->json(['data' => $style], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error retrieving style: ' . $e->getMessage());

            return response()->json(['error' => 'Style not found', 'message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}

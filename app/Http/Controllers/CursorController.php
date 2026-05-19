<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\CursorMoved;

class CursorController extends Controller
{
    public function move(Request $request)
    {
        try {

            broadcast(new CursorMoved(
                $request->document_id,
                $request->position,
                'refa papaw'
            ))->toOthers();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        }
    }
}
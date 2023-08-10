<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{

    public function create_position()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $position = Position::create([
            'name' => request('name'),
        ]);

        if ($position) {
            return response()->json(['message' => 'Position of Employee is successfully added']);
        } else {
            return response()->json(['message' => 'Position of Employee is failed added']);
        }
    }

    public function get_positions()
    {
        $position = Position::all();

        return response()->json($position);
    }
}

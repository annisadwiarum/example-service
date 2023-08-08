<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create_holiday']]);
    }

    public function create_holiday()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'holiday_date' => 'required|date|unique:holidays'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $holiday = Holiday::create([
            'title' =>  request('title'),
            'description' =>  request('description'),
            'holiday_date' =>  request('holiday_date'),
        ]);

        if ($holiday) {
            return response()->json(['message' => 'Holiday is successfully added']);
        } else {
            return response()->json(['message' => 'Holiday is failed added']);
        }
    }
}

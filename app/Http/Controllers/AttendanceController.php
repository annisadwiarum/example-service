<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create_attendance']]);
    }

    public function create_attendance()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'limit_start_time' => 'required',
            'end_time' => 'required',
            'limit_end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $attendance = Attendance::create([
            'title' => request('title'),
            'description' => request('description'),
            'start_time' => request('start_time'),
            'limit_start_time' => request('limit_start_time'),
            'end_time' => request('end_time'),
            'limit_end_time' => request('limit_end_time'),
        ]);

        if ($attendance) {
            return response()->json(['message' => 'Absensi Berhasil ditambahkan']);
        } else {
            return response()->json(['message' => 'Absensi Gagal ditambahkan']);
        }
    }
}

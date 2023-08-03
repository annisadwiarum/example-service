<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create']]);
    }

    public function create()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'division' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $precense = Presence::create([
            'name' => request('name'),
            'division' => request('division'),
            'date' => request('time'),

        ]);

        if ($precense) {
            return response()->json(['message' => 'Data Karyawan Berhasil di Inputkan']);
        } else {
            return response()->json(['message' => 'Data Karyawan Gagal di Inputkan']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create']]);
    }

    public function create()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees',
            'phone_number' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'division' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $employee = Employee::create([
            'title' => request('title'),
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone_number' => request('phone_number'),
            'place_of_birth' => request('place_of_birth'),
            'date_of_birth' => request('date_of_birth'),
            'gender' => request('gender'),
            'address' => request('address'),
            'division' => request('division'),
        ]);

        if ($employee) {
            return response()->json(['message' => 'Data Karyawan Berhasil di Inputkan']);
        } else {
            return response()->json(['message' => 'Data Karyawan Gagal di Inputkan']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create', 'token_employee', 'delete_employee']]);
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

    public function delete_employee(Request $request)
    {
        $request->validate(['id' => 'required']);

        $employee = Employee::find($request->input('id'));

        if (!$employee) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }
        // Tambahkan baris berikut untuk mencetak pesan sebelum penghapusan
        // dd('Sedang menghapus karyawan dengan ID: ' . $employee->id);

        $employee->delete();
        return response()->json(['message' => 'Data karyawan berhasil dihapus']);
    }

    public function edit_employee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // if (!$employee) {
        //     return response()->json(['message' => 'Data karyawan tidak ditemukan']);
        // }
        $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:255',
            'address' => 'required|string',
            'division' => 'required|string',
        ]);

        // Update the employee data
        $employee->title = $request->input('title');
        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->email = $request->input('email');
        $employee->phone_number = $request->input('phone_number');
        $employee->place_of_birth = $request->input('place_of_birth');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->gender = $request->input('gender');
        $employee->address = $request->input('address');
        $employee->division = $request->input('division');
        $employee->save();

        return response()->json(['message' => 'Employee data updated successfully']);
    }
}

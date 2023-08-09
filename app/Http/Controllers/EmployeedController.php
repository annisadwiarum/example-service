<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['add_employeed']]);
    }

    public function add_employeed()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'password' => 'required',
            'phone' => 'required',
            'position_id' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $employeed = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'phone' => request('phone'),
            'position_id' => request('position_id'),
            'role_id' => request('role_id'),
        ]);

        if ($employeed) {
            return response()->json(['message' => 'Data Karyawan Berhasil ditambahkan']);
        } else {
            return response()->json(['message' => 'Data Karyawan Gagal ditambahkan']);
        }
    }

    public function delete_employeed(Request $request)
    {
        $request->validate(['id' => 'required']);

        $employeed = User::find($request->input('id'));

        if (!$employeed) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }
        // Tambahkan baris berikut untuk mencetak pesan sebelum penghapusan
        // dd('Sedang menghapus karyawan dengan ID: ' . $employee->id);

        $employeed->delete();
        return response()->json(['message' => 'Data karyawan berhasil dihapus']);
    }

    public function edit_employeed(Request $request, $id)
    {
        $employeed = User::findOrFail($id);

        // if (!$employee) {
        //     return response()->json(['message' => 'Data karyawan tidak ditemukan']);
        // }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'position_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        // Update the employee data
        $employeed->name = $request->input('name');
        $employeed->email = $request->input('email');
        $employeed->phone = $request->input('phone');
        $employeed->password = $request->input('password');
        $employeed->position_id = $request->input('position_id');
        $employeed->role_id = $request->input('role_id');
        $employeed->save();

        return response()->json(['message' => 'Data Karyawan telah di perbaharui']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get_roles()
    {
        $role = Role::all();

        return response()->json($role);
    }
}

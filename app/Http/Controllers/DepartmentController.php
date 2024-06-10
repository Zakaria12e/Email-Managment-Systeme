<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Role;

class DepartmentController extends Controller
{



    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'dept_name' => 'required',
            'chef_dept' => 'required',
            'description' => 'required',
        ]);


        $department = Department::create($validatedData);


        return response()->json($department, 201);

    }

    public function index()
    {
        try {
            $departments = Department::all();
            return response()->json($departments);
        } catch (\Exception $e) {
            report($e);
            return abort(500, 'Error fetching departments');
        }
    }

    public function getroles()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            report($e);
            return abort(500, 'Error fetching roles');
        }
    }

    public function storeRoles(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);


        $role = Role::create($validatedData);


        return response()->json($role, 201);

    }


}

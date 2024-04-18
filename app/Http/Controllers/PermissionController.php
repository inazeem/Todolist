<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    //

    public function index(){

        $permissions = Permission::all();
        return inertia::render('Permissions/Index',compact('permissions'));

    }


    public function Create(){

        return inertia::render('Permissions/Create');

    }

    public function Store(Request $request){

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission = new Permission;
        $permission->name = $validated_data['name'];
        $permission->guard_name = $validated_data['name'];
        $permission->save(); //insert


        return Redirect::route('permissions.index');
    }
}

<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //

    public function index(){

        $permissions = Permission::all();
        $roles = Role::all();
        return inertia::render('Permissions/Index',compact('permissions','roles'));

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

    public function assignRole(Request $request){

        //return $request;
        $roles = $request->role454;
        $permission = Permission::find($request->pid);

       // return $permission;

        foreach($roles as $role){
            $role = Role::find($role);

            //return $role;
            $role->givePermissionTo($permission->name);
        }

        return Redirect::route('permissions.index')->with('message','Permissions assigned to roles successfully!');

    }
}

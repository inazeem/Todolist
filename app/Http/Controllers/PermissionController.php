<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    //

    public function index(){

        $permissions = Permission::all();
        $roles = Role::all();
        return inertia::render('App/Permissions/Index',compact('permissions','roles'));

    }


    public function Create(){

        return inertia::render('App/Permissions/Create');

    }

    public function Store(Request $request){

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission = new Permission;
        $permission->name = $validated_data['name'];
        $permission->guard_name = 'web';
        $permission->save(); //insert
        return redirect('/app/permissions')->with(['message' =>  'Permission created Successfully.','class' => 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800']);

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

        return redirect('/app/permissions')->with(['message' =>  'Permissions assigned to roles successfully!','class' => 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800']);
    }
}

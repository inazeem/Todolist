<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    //

    public function index(){

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return inertia::render('App/Roles/Index',compact('roles','permissions'));

    }


    public function Create(){

        return inertia::render('App/Roles/Create');

    }

    public function Store(Request $request){

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = new Role;
        $role->name = $validated_data['name'];
        $role->guard_name = $validated_data['name'];
        $role->save(); //insert
        return redirect('/app/roles')->with(['message' =>  'Role Created Successfully.','class' => 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800']);
    }

    public function edit($rid){

        $role = Role::find($rid);
        return inertia::render('App/Roles/Edit',compact('role'));
    }

    public function update(Request $request ){

        $validated_data = $request->validate([
            'id' => 'required|integer|max:255',
            'name' => 'required|string|max:255',
        ]);


        $role = Role::find($validated_data['id']);
        $role->name =  $validated_data['name'];
        $role->guard_name =  'web';
        $role->save(); //insert

        $roles = Role::all();
        //return redirect('/app/roles')->with('message', 'Role Updated Successfully');
        return redirect('/app/roles')->with(['message' =>  'Role Updated Successfully.','class' => 'p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800']);
    }

    public function updaetPermissions(Request $request){

        $role = Role::find($request->role);
        $role->syncPermissions($request->permission1);

        return redirect('roles')->with('message', 'Permissions Updated Successfully');
    }

    public function destroy($rid){

        return $rid;
        $role = Role::find($rid);
        $role->delete();
        sleep(1);

        return redirect('roles')->with('message', 'Role Deleted Successfully');
    }
}

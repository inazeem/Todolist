<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index(){

        $users =  User::with('roles')->get();
        $roles = Role::all();
        return inertia::render('Users/Index',compact('users','roles'));

    }

    public function create(){
        return inertia::render('Users/Create');
    }



    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect('users')->with('message', 'User Created Successfully');
    }

    public function updateRoles(Request $request){

        $user = User::find($request->uid);
        $user->syncRoles($request->userRoles);
        return redirect('users')->with('message', 'Roles Assigned Successfully');
    }
}

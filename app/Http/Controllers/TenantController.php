<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tenant;
use Auth;
use Illuminate\Validation\Rules;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();

        return Inertia::render('Tenants/Index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:Domains,domain',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //return $validated_data;

        // $tenant = new Tenant;
        // $tenant->name = $validated_data['name'];
        // $tenant->domain = $validated_data['domain'];
        // $tenant->email = $validated_data['email'];
        // $tenant->password = $validated_data['password'];
        // $tenant->save();


        $tenant = Tenant::create([
            $validated_data
        ]);

        $tenant->domains()->create([
            'domain' => $validated_data['domain'].'.localhost',
        ]);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

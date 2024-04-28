<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Tenant, User};

class SeedTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

     protected $tenant;
    public function __construct(Tenant $tenant)
    {
        //
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // dd($this->tenant->getAttributes()[0]['name']);
        $this->tenant->run(function(){

            User::create([
                'name' => $this->tenant->getAttributes()[0]['name'],
                'email' => $this->tenant->getAttributes()[0]['email'],
                'password' => $this->tenant->getAttributes()[0]['password'],
            ]);
        });
    }
}

<?php

namespace App\Providers;

use App\Group;
use App\Swimmer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Swimmer::creating(function ($swimmer) {
            $name = $swimmer->first_name . ' ' . $swimmer->last_name;
            $swimmer->slug = createSlug($name);
        });

        Group::creating(function ($group) {
            $group->slug = createSlug($group->name  . '-' . str_random(5));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Event::listen('eloquent.saving:*', function ($event, $models) {
            $model = $models[0];
            $table_name = $model->getTable();
            $model_attributes = Schema::getColumnListing($table_name);
            if (in_array('created_by', $model_attributes)) {
                if (!isset($model->created_by)) {
                    $auth_id = \Auth::id();
                    // dd($auth_id);
                    if (isset($auth_id)) {
                        $model->created_by = $auth_id;
                    } else {
                        $model->created_by = '1';
                    }
                }
            }
        });

    }
}

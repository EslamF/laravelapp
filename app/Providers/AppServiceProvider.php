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
            if (in_array('user_id', $model_attributes)) {
                if (!isset($model->user_id)) {
                    $auth_id = \Auth::id();
                    if (isset($auth_id)) {
                        $model->user_id = $auth_id;
                    } else {
                        $model->user_id = '1';
                    }
                }
            }
        });
    }
}

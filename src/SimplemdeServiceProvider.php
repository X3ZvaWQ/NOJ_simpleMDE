<?php

namespace Encore\Simplemde;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class SimplemdeServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Simplemde $extension)
    {
        if (! Simplemde::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-simplemde');
        }
        
        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/simplemde')],
                'laravel-admin-simplemde'
            );
        }

        Admin::booting(function () {
            Form::extend('simplemde', Editor::class);

            if ($alias = Simplemde::config('alias')) {
                Form::alias('simplemde', $alias);
            }
        });
    }
}
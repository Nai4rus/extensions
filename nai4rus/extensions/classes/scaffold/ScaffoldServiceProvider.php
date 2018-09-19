<?php namespace Nai4rus\Extensions\Classes\Scaffold;

use Illuminate\Support\ServiceProvider;
use Nai4rus\Extensions\Classes\Scaffold\Console\CreateController;
use Nai4rus\Extensions\Classes\Scaffold\Console\CreateModel;
use Nai4rus\Extensions\Classes\Scaffold\Console\CreatePlugin;

class ScaffoldServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton('command.create.model.ext', function () {
            return new CreateModel;
        });

        $this->app->singleton('command.create.controller.ext', function () {
            return new CreateController;
        });

        $this->app->singleton('command.create.plugin.ext', function () {
            return new CreatePlugin;
        });


        $this->commands('command.create.model.ext');
        $this->commands('command.create.controller.ext');
        $this->commands('command.create.plugin.ext');
    }

    public function provides() {
        return [
            'command.create.model',
            'command.create.plugin',
            'command.create.controller',
        ];
    }
}

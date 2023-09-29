<?php namespace Aic\GoogleCalendar;
use System\Classes\PluginBase;

use App;
use Config;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase {

    public function pluginDetails()
    {
        return [
            'name'        => 'Google Calendar',
            'description' => 'Wrapper plugin for Spatie Laravel Google Calendar: https://github.com/spatie/laravel-google-calendar',
            'author'      => 'Meindert Stijfhals',
            'icon'        => 'icon-calendar'
        ];
    }
    
    public function boot()
    {
        $this->bootPackages();
    }

    public function register()
    {
        // Instantiate the AliasLoader
        $aliasLoader = AliasLoader::getInstance();

        // Register the aliases provided by the packages used by your plugin
        $aliasLoader->alias('GoogleCalendar', \Spatie\GoogleCalendar\GoogleCalendarFacade::class);

        // Register the service providers provided by the packages used by your plugin
        App::register(\Spatie\GoogleCalendar\GoogleCalendarServiceProvider::class);

    }

    public function bootPackages()
    {
        // Get the namespace code of the current plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Locate the packages to boot
        $packages = Config::get($pluginNamespace . '::packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Apply the configuration for the package
            if (
                !empty($options['config']) &&
                !empty($options['config_namespace'])
            ) {
                Config::set($options['config_namespace'], $options['config']);
            }
        }
    }

}
<?php

namespace HaroutItology\AwsTimestream;

use Illuminate\Support\ServiceProvider;
use HaroutItology\AwsTimestream\Builder\PayloadBuilder;
use HaroutItology\AwsTimestream\Contract\PayloadBuilderContract;

class TimestreamServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();
    }

    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'timestream');

        $this->app->bind(PayloadBuilderContract::class, PayloadBuilder::class);

        $this->app->singleton(TimestreamManager::class, function ($app) {
            return new TimestreamManager(
                config('timestream.key'),
                config('timestream.secret'),
                config('timestream.profile'),
                config('timestream.version'),
                config('timestream.region'),
            );
        });
    }

    /**
     * Return config file.
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/timestream.php';
    }

    /**
     * Publish config file.
     */
    protected function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->configPath() => config_path('timestream.php'),
            ], 'timestream-config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [TimestreamManager::class];
    }
}

<?php namespace Oz\Webhooks;

use Illuminate\Support\ServiceProvider;
use Oz\Webhooks\Console\WebhookMakeCommand;
use Oz\Webhooks\Contract\EventClassHandlerInterface;
use Oz\Webhooks\Contract\WebhookClassHandlerInterface;
use Oz\Webhooks\Contract\WebhooksInterface;
use Oz\Webhooks\Handler\EventClassHandler;
use Oz\Webhooks\Handler\WebhookClassHandler;

class WebhooksServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WebhookMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(WebhooksInterface::class, Webhooks::class);
        $this->app->bind(EventClassHandlerInterface::class, EventClassHandler::class);
        $this->app->bind(WebhookClassHandlerInterface::class, WebhookClassHandler::class);
    }

}
<?php namespace Obrignoni\Webhooks;

use Illuminate\Support\ServiceProvider;
use Obrignoni\Webhooks\Console\WebhookMakeCommand;
use Obrignoni\Webhooks\Contract\EventClassHandlerInterface;
use Obrignoni\Webhooks\Contract\WebhookClassHandlerInterface;
use Obrignoni\Webhooks\Contract\WebhooksInterface;
use Obrignoni\Webhooks\Handler\EventClassHandler;
use Obrignoni\Webhooks\Handler\WebhookClassHandler;

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
<?php namespace Oz\Webhook;

use Illuminate\Support\ServiceProvider;
use Oz\Webhook\Contract\WebhookInterface;

class WebhookServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(WebhookInterface::class, Webhook::class);
    }

}
<?php namespace Oz\Webhook;

use Oz\Webhook\Contract\WebhookInterface;

class Webhook implements WebhookInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace()
    {
        return config('webhook.events.namespace', 'App\\Events\\');
    }

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getWebhookRequestNamespace()
    {
        return config('webhook.requests.namespace', 'App\\Http\\Requests\\');
    }
    
}
<?php namespace Oz\Webhooks;

use Oz\Webhooks\Contract\WebhooksInterface;

class Webhooks implements WebhooksInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace()
    {
        return config('webhooks.events.namespace', 'App\\Events\\');
    }

    /**
     * Get the webhooks request namespace.
     *
     * @return string
     */
    public function getWebhookRequestNamespace()
    {
        return config('webhooks.requests.namespace', 'App\\Http\\Requests\\');
    }
    
}
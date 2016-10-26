<?php namespace Oz\Webhook\Contract;

interface WebhookInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace();

}
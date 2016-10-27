<?php namespace Oz\Webhooks\Contract;

interface WebhooksInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace();

}
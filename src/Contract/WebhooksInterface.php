<?php namespace Oz\Webhooks\Contract;

interface WebhooksInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace();

    /**
     * Get the webhooks request namespace.
     *
     * @return string
     */
    public function getWebhooksNamespace();

    /**
     * Call a webhook by name.
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function call($name);

}
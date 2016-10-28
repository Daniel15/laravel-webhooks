<?php namespace Oz\Webhooks\Contract;

interface WebhookClassHandlerInterface
{

    /**
     * Transform the webhook name to a class.
     *
     * @param string $name
     * @return string
     */
    public function getWebhookClass($name);

}
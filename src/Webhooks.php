<?php namespace Obrignoni\Webhooks;

use Obrignoni\Webhooks\Contract\WebhookClassHandlerInterface;
use Obrignoni\Webhooks\Contract\WebhooksInterface;
use Obrignoni\Webhooks\Http\WebhookRequest;

class Webhooks implements WebhooksInterface
{

    /**
     * Get the events namespace.
     *
     * @return string
     */
    public function getEventsNamespace()
    {
        return app()->getNamespace() . 'Events';
    }

    /**
     * Get the webhooks request namespace.
     *
     * @return string
     */
    public function getWebhooksNamespace()
    {
        return config('webhooks.namespace', app()->getNamespace() . 'Http\\Webhooks');
    }

    /**
     * Call a webhook by name.
     *
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function call($name)
    {
        if ($this->isDiscoverable($name))
        {
            return;
        }

        /** @var WebhookRequest $webhook */
        if ($webhook = $this->getWebhookRequest($name)) {
            $webhook->fireEvent();
        } else {
            abort(404, 'Webhook not found.');
        }
    }

    /**
     * Are webhooks discoverable.
     *
     * @param string $name
     * @return boolean
     */
    public function isDiscoverable($name)
    {
        return in_array($name, config('webhooks.discoverable', []));
    }

    /**
     * Get the webhook request.
     *
     * @param string $name
     * @return WebhookRequest|null
     */
    protected function getWebhookRequest($name)
    {
        $webhookRequest = $this->getWebhookClass($name);

        if (!class_exists($webhookRequest)) {
            return null;
        }

        return app($webhookRequest);
    }

    /**
     * Get the webhook request class.
     *
     * @param string $name
     * @return string
     */
    protected function getWebhookClass($name)
    {
        return $this->getWebhookClassHandler()->getWebhookClass($name);
    }

    /**
     * Get the webhook class handler.
     *
     * @return WebhookClassHandlerInterface
     */
    protected function getWebhookClassHandler()
    {
        return app(WebhookClassHandlerInterface::class);
    }

}
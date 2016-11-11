<?php namespace Obrignoni\Webhooks\Handler;

use Obrignoni\Webhooks\Contract\WebhookClassHandlerInterface;
use Obrignoni\Webhooks\Contract\WebhooksInterface;

class WebhookClassHandler implements WebhookClassHandlerInterface
{

    /**
     * @var WebhooksInterface
     */
    protected $webhooks;

    /**
     * EventClassHandler constructor.
     * @param WebhooksInterface $webhooks
     * @internal param string $webhookName
     */
    public function __construct(WebhooksInterface $webhooks)
    {
        $this->webhooks = $webhooks;
    }

    /**
     * Transform the webhook name to a class.
     *
     * @param string $name
     * @return string
     */
    public function getWebhookClass($name)
    {
        return $this->webhooks->getWebhooksNamespace() . '\\' . studly_case($name);
    }

}
<?php namespace Oz\Webhooks\Handler;

use Oz\Webhooks\Contract\WebhooksInterface;

class EventClassHandler
{

    /**
     * The webhook name.
     *
     * @var string
     */
    protected $webhookName;

    /**
     * The event name.
     *
     * @var string
     */
    protected $eventName;

    /**
     * The event map.
     *
     * @var array
     */
    protected $eventMap;

    /**
     * EventClassHandler constructor.
     * @param $webhookName
     * @param string $eventName
     * @param $eventMap
     */
    public function __construct($webhookName, $eventName, array $eventMap = [])
    {
        $this->eventName = $eventName;
        $this->webhookName = $webhookName;
        $this->eventMap = $eventMap;
    }

    /**
     * Handle the transformation to the event class.
     *
     * @param WebhooksInterface $webhooks
     * @return string
     */
    public function handle(WebhooksInterface $webhooks)
    {
        $class = $this->getEventClassFromMap($this->getEventClass($webhooks));

        if ( ! starts_with($class, $webhooks->getEventsNamespace()))
        {
            $class = $webhooks->getEventsNamespace() . $class;
        }

        return $class;
    }

    /**
     * Get the event class.
     *
     * @param WebhooksInterface $webhooks
     * @return string
     */
    protected function getEventClass(WebhooksInterface $webhooks)
    {
        return $webhooks->getEventsNamespace() . $this->getWebhookName() . $this->getEventName();
    }

    /**
     * Get the event class from the event map array or return a default value.
     *
     * @param null $default
     * @return mixed
     */
    protected function getEventClassFromMap($default = null)
    {
        return array_get($this->eventMap, $this->eventName, $default);
    }

    /**
     * Transform the event name.
     *
     * @return string
     */
    protected function getWebhookName()
    {
        return $this->transformName($this->webhookName);
    }


    /**
     * Transform the event name.
     *
     * @return string
     */
    protected function getEventName()
    {
        return $this->transformName($this->eventName);
    }

    /**
     * Transform a name.
     *
     * @param $name
     * @return string
     */
    protected function transformName($name)
    {
        return studly_case(str_replace([':', '-'], '_', $name));
    }

}
<?php namespace Obrignoni\Webhooks\Http;

use Illuminate\Foundation\Http\FormRequest;
use Obrignoni\Webhooks\Contract\EventClassHandlerInterface;
use Obrignoni\Webhooks\Contract\WebhooksInterface;

abstract class WebhookRequest extends FormRequest
{

    /**
     * The event field from the headers or the request.
     *
     * Example:
     *
     * $eventField = 'X-GitHub-Event';
     *
     * @var string|null
     */
    protected $eventField;

    /**
     * Get the events. Map each webhook event to a event class.
     *
     * Example #1:
     *
     * $events = [
     *    'PullRequestEvent' => 'App\Events\GithubPullRequestEvent',
     * ];
     *
     * Example #2:
     *
     * $events = App\Events\SingleEventForAll;
     *
     * @var array|string
     */
    protected $events = [];

    /**
     * Determine if the request passes the authorization check.
     *
     * @return boolean
     */
    protected function passesAuthorization()
    {
        if ($this->authorization) {
            return app()->call($this->authorization . '@handle');
        }

        return parent::passesAuthorization();
    }

    /**
     * Fire an event.
     *
     * @param string
     *
     * @return void
     */
    public function fireEvent()
    {
        if (class_exists($eventClass = $this->getEventClass())) {
            event(new $eventClass($this->request->all()));
        }
    }

    /**
     * Get the event class.
     *
     * @return string
     */
    protected function getEventClass()
    {
        return $this->getEventClassHandler()->getEventClass();
    }

    /**
     * Get the event class handler.
     *
     * @return EventClassHandlerInterface
     */
    protected function getEventClassHandler()
    {
        return app(EventClassHandlerInterface::class, [
            app(WebhooksInterface::class),
            $this->getWebhookName(),
            $this->getEventName(),
            $this->getEvents(),
        ]);
    }

    /**
     * Get the events array.
     *
     * @return array|string
     */
    protected function getEvents()
    {
        return $this->events;
    }

    /**
     * Get the event field.
     *
     * @return null|string
     */
    protected function getEventField()
    {
        return $this->eventField;
    }

    /**
     * @return string
     */
    protected function getEventName()
    {
        return $this->request->get($this->getEventField());
    }

    /**
     * Get the webhook class.
     *
     * @return string
     */
    protected function getWebhookName()
    {
        return class_basename(get_called_class());
    }

}

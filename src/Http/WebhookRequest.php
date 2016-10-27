<?php namespace Oz\Webhooks\Http;

use Illuminate\Foundation\Http\FormRequest;
use Oz\Webhooks\Handler\EventClassHandler;

class WebhookRequest extends FormRequest
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
     * @return bool
     */
    protected function passesAuthorization()
    {
        if ($this->authorization) {
            return app()->call($this->authorization . '@handle');
        }

        return parent::passesAuthorization();
    }

    /**
     * @param string $hookName
     *
     * @return void
     */
    public function call($hookName)
    {
        if (class_exists($eventClass = $this->getEventClass($hookName))) {
            event(new $eventClass($this->request->all()));
        }
    }

    /**
     * @param string $hookName
     * @return string
     */
    public function getEventClass($hookName)
    {
        return app()->call(EventClassHandler::class . '@handle', [$hookName, $this->getEventName(), $this->getEvents()]);
    }

    /**
     * Get the events array.
     *
     * @return array|string
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Get the event field.
     *
     * @return null|string
     */
    public function getEventField()
    {
        return $this->eventField;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->request->get($this->getEventField());
    }

}

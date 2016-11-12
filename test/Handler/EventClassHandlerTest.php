<?php namespace Obrignoni\Webhook\Test\Handler;

use Obrignoni\Webhooks\Contract\WebhooksInterface;
use Obrignoni\Webhooks\Handler\EventClassHandler;
use Obrignoni\Webhooks\Webhooks;

class EventClassHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Event map.
     *
     * @var array
     */
    protected $eventMap = [
        'one' => 'EventOne',
        'two' => 'App\\Events\\EventTwo',
    ];

    /**
     * Test that we get the default event class.
     */
    public function testScenarios()
    {
        foreach($this->getScenarios() as $scenario)
        {
            $this->assertEquals($scenario['expected'], $this->getEventClass(
                $scenario['webhookName'],
                $scenario['eventName']
            ));
        }
    }

    /**
     * Get all the scenarios.
     *
     * @return array
     */
    public function getScenarios()
    {
        return [
            [
                'webhookName' => 'foo',
                'eventName' => 'bar',
                'expected' => 'App\\Events\\FooBar',
            ],
            [
                'webhookName' => 'foo',
                'eventName' => 'one',
                'expected' => 'App\\Events\\EventOne',
            ],
            [
                'webhookName' => 'foo',
                'eventName' => 'two',
                'expected' => 'App\\Events\\EventTwo',
            ],
            [
                'webhookName' => 'github',
                'eventName' => 'PullRequestEvent',
                'expected' => 'App\\Events\\GithubPullRequestEvent',
            ],
        ];
    }

    /**
     * Get the event class.
     *
     * @param $webhookName
     * @param $eventName
     * @return string
     */
    protected function getEventClass($webhookName, $eventName)
    {
        $webhooks = \Mockery::mock(Webhooks::class);

        $webhooks->shouldReceive('getEventsNamespace')->andReturn('App\\Events');

        return $this->getEventClassHandler($webhooks, $webhookName, $eventName)->getEventClass();
    }

    /**
     * Get the event class handler.
     *
     * @param WebhooksInterface $webhooks
     * @param $webhookName
     * @param $eventName
     * @return EventClassHandler
     */
    protected function getEventClassHandler($webhooks, $webhookName, $eventName)
    {
        return new EventClassHandler($webhooks, $webhookName, $eventName, $this->eventMap);
    }

}
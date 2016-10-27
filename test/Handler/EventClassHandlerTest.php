<?php namespace Oz\Webhook\Test\Handler;

use Oz\Webhooks\Handler\EventClassHandler;
use Oz\Webhooks\Webhooks;

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
        $webhook = \Mockery::mock(Webhooks::class);

        $webhook->shouldReceive('getEventsNamespace')->andReturn('App\\Events\\');

        return $this->getEventClassHandler($webhookName, $eventName)->handle($webhook);
    }

    /**
     * Get the event class handler.
     *
     * @param $webhookName
     * @param $eventName
     * @return EventClassHandler
     */
    protected function getEventClassHandler($webhookName, $eventName)
    {
        return new EventClassHandler($webhookName, $eventName, $this->eventMap);
    }

}
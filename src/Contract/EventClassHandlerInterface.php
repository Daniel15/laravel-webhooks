<?php namespace Oz\Webhooks\Contract;

interface EventClassHandlerInterface
{

    /**
     * Transform the event name to a class.
     *
     * @return string
     */
    public function getEventClass();

}
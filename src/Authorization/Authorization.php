<?php namespace Oz\Webhooks\Authorization;

use Illuminate\Http\Request;

abstract class Authorization
{

    /**
     * The http request.
     *
     * @var Request
     */
    protected $request;

    /**
     * The webhook token defined in our application environment.
     *
     * @var string|null
     */
    protected $token;

    /**
     * @param Request $request
     * @return Authorization
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param null|string $token
     * @return Authorization
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
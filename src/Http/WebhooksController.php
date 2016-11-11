<?php namespace Obrignoni\Webhooks\Http;

use Obrignoni\Webhooks\Contract\WebhooksInterface;

class WebhooksController
{

    /**
     * @var WebhooksInterface
     */
    protected $webhooks;

    /**
     * The constructor.
     *
     * WebhooksController constructor.
     * @param WebhooksInterface $webhooks
     */
    public function __construct(WebhooksInterface $webhooks)
    {
        $this->webhooks = $webhooks;
    }

    /**
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($name)
    {
        $this->webhooks->call($name);

        return response()->json([
            'ok' => true,
        ]);
    }

}
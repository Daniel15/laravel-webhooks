<?php namespace Oz\Webhook\Http;

class WebhookController
{

    /**
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($name)
    {
        if ($webhook = $this->getWebhookRequest($name))
        {
            $webhook->call($name);
        }

        return response()->json([
            'ok' => true,
        ]);
    }

    /**
     * @param string $name
     * @return WebhookRequest|null
     */
    public function getWebhookRequest($name)
    {
        $webhookRequest = $this->getWebhookRequestClass($name);

        if ( ! class_exists($webhookRequest))
        {
            return null;
        }

        return new $webhookRequest($name);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getWebhookRequestClass($name)
    {
        return 'App\\Http\\Requests\\Webhook' . studly_case($name);
    }

}
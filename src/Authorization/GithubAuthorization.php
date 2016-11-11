<?php namespace Obrignoni\Webhooks\Authorization;

class GithubAuthorization extends Authorization
{

    /**
     * Validate Github's signature using our stored webhook token.
     *
     * @return boolean
     * @throws
     */
    public function handle()
    {
        list ($algorithm, $gitHubSignature) = explode("=", $this->request->header('x-github-signature'));

        if ($algorithm !== 'sha1') {
            // see https://developer.github.com/webhooks/securing/
            throw new \DomainException('Github webhook signature hash algorithm must be sha1.');
        }

        $payloadHash = hash_hmac($algorithm, $payload = $this->request->getContent(), $this->token);

        return ($payloadHash === $gitHubSignature);
    }

}
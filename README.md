# Laravel Webhooks

This Laravel package helps you organize, secure and map webhooks to events.

### Installation

To get started, install Passport via the Composer package manager:

```
composer require obrignoni/webhooks
```

Next, register the Webhooks service provider in the providers array of your config/app.php configuration file:

```
Oz\Webhooks\WebhooksServiceProvider::class,
```

### Why create a webhooks package? 

I wanted to...

1. integrate my applications with webhooks from different services.
2. keep my webhooks organized.
3. secure my webhooks.
4. map webhook events to Laravel events.
5. do all this with a simple convention that felt as familiar as Laravel.

### Usage

Lets take [Github Webhooks](https://developer.github.com/webhooks/) for example. 

A github webhook payload looks like this...

```
POST /payload HTTP/1.1

Host: localhost:4567
X-Github-Delivery: 72d3162e-cc78-11e3-81ab-4c9367dc0958
User-Agent: GitHub-Hookshot/044aadd
Content-Type: application/json
Content-Length: 6615
X-GitHub-Event: issues

{
  "action": "opened",
  "issue": {
    "url": "https://api.github.com/repos/octocat/Hello-World/issues/1347",
    "number": 1347,
    ...
  },
  "repository" : {
    "id": 1296269,
    "full_name": "octocat/Hello-World",
    "owner": {
      "login": "octocat",
      "id": 1,
      ...
    },
    ...
  },
  "sender": {
    "login": "octocat",
    "id": 1,
    ...
  }
}
```

Notice the `X-GitHub-Event` header contains `issues`, one of [Github Events](https://developer.github.com/webhooks/#events).

We can use an artisan command to setup a webhook for github.

```
php artisan make:webhook github
```

This will create the `App\Http\Webhooks\Github` class.
 
The webhook class extends a WebhookRequest which also extends a 
FormRequest and adds a couple of extra configuration options.

Lets take a look at the generated class.

```php
<?php namespace App\Http\Webhooks;

use Oz\Webhooks\Http\WebhookRequest;

class Github extends WebhookRequest
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
    protected $eventField = '';

    /**
     * Map each webhook event to a event class. If left empty, event names will be transformed to studly cased classes.
     *
     * Example: For a Github webhook, the pull_request event will be transformed to App\Events\GithubPullRequest.
     *
     * Example #1:
     *
     * $events = [
     *    'pull_request' => 'App\Events\MyCustomEvent',
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
     * The authorization handler class. Optional. Use a handler in lieu of the authorize method.
     *
     * @var string
     */
    protected $authorization = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        // Authorize the webhook the same way you would with a FormRequest.

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

}
```

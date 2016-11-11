# Laravel Webhooks

This Laravel package helps you organize, secure and map webhooks to events.

### Installation

To get started, install Laravel Webhooks via the Composer package manager:

```
composer require obrignoni/webhooks
```

Next, register the Webhooks service provider in the providers array of your config/app.php configuration file:

```
Obrignoni\Webhooks\WebhooksServiceProvider::class,
```

### Why a webhooks package? 

I want to...

1. integrate my applications with webhooks from multiple services.
2. keep the webhooks organized and secure.
3. map webhook events to Laravel events.

### Usage

Lets take [Github Webhooks](https://developer.github.com/webhooks/) for example. 

A Github webhook payload looks like this...

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

use Obrignoni\Webhooks\Http\WebhookRequest;

class Github extends WebhookRequest
{

    protected $eventField = '';

    protected $events = [];

    protected $authorization = null;

    public function authorize()
    {
        // Authorize the webhook the same way you would with a FormRequest.

        return false;
    }

    public function rules()
    {
        return [

        ];
    }

}
```

We can setup our Github webhook like this...

```php
<?php namespace App\Http\Webhooks;

use Obrignoni\Webhooks\Authorization\GithubAuthorization;
use Obrignoni\Webhooks\Http\WebhookRequest;

class Github extends WebhookRequest
{

    protected $eventField = 'X-GitHub-Event';

    protected $authorization = GithubAuthorization::class;

}
```

## Event Field

The event field is the request parameter or header that contains the event value.

### Authorization Handler

The authorization handler can contain the logic to authorize the request. It should return a boolean value.

The `$authorization` is set to the `GithubAuthorization` handler that is included with this package. 
Using an authorization handler is optional and it can be used in lieu of the authorize.

### Mapped Events

You use the `$events` array to map each webhook event to an event class. If left empty, event names will be automatically 
transformed to studly cased classes. For a Github webhook, the `pull_request` event will be transformed to 
`App\Events\GithubPullRequest`.

Here as an example of how to set up custom events.

```php
<?php namespace App\Http\Webhooks;

use Obrignoni\Webhooks\Authorization\GithubAuthorization;
use Obrignoni\Webhooks\Http\WebhookRequest;

class Github extends WebhookRequest
{

    protected $field = 'X-GitHub-Event';

    protected $authorization = GithubAuthorization::class;

    protected $events = [
        'issue_comment' => 'App\Events\SomebodyMadeACommentOnGithub',  
        'pull_request' => 'App\Events\SomebodySubmittedAPullRequest',  
    ];

}
```

### Webhook Requests Extend Form Requests

You have the option of using the `authorize` and `rules` methods just like [Form Requests](https://laravel.com/docs/5.3/validation#form-request-validation).


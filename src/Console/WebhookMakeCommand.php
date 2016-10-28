<?php namespace Oz\Webhooks\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Oz\Webhooks\Contract\WebhooksInterface;

class WebhookMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new webhook request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Webhook';

    /**
     * @var WebhooksInterface
     */
    protected $webhooks;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(Filesystem $files, WebhooksInterface $webhooks)
    {
        parent::__construct($files);

        $this->webhooks = $webhooks;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../stub/webhook.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->webhooks->getWebhooksNamespace();
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return studly_case(parent::getNameInput());
    }
}
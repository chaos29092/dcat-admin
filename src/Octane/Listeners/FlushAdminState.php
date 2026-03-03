<?php

namespace Dcat\Admin\Octane\Listeners;

use Dcat\Admin\AdminServiceProvider;
use Illuminate\Container\Container;

class FlushAdminState
{
    protected $adminServices = [
        'admin.app',
        'admin.asset',
        'admin.color',
        'admin.sections',
        'admin.extend',
        'admin.extend.update',
        'admin.extend.version',
        'admin.navbar',
        'admin.menu',
        'admin.context',
        'admin.setting',
        'admin.web-uploader',
        'admin.translator',
    ];

    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    public function handle($event): void
    {
        $provider = new AdminServiceProvider($event->sandbox);

        $this->forgetServiceInstances($event->sandbox);

        $provider->registerServices();
        $provider->registerExtensions();
        $provider->boot();
    }

    protected function forgetServiceInstances(Container $container)
    {
        foreach ($this->adminServices as $service) {
            $container->forgetInstance($service);
        }
    }
}

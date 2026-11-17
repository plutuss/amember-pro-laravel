<?php

namespace Plutuss\AMember\Tests;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Providers\AMemberServiceProvider;
use Plutuss\AMember\Response\AdapterResponse;
use ReflectionProperty;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [AMemberServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('amember.amember_url', 'https://amember.test/api/');
        $app['config']->set('amember.amember_api_key', 'test-key');
        $app['config']->set('amember.type_response.default', 'array');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->resetPackageInstances();
        Http::preventStrayRequests();
    }

    protected function tearDown(): void
    {
        $this->resetPackageInstances();
        parent::tearDown();
    }

    private function resetPackageInstances(): void
    {
        foreach ([AMemberClient::class, AdapterResponse::class] as $class) {
            $property = new ReflectionProperty($class, 'instance');
            $property->setAccessible(true);
            $property->setValue(null, null);
        }
    }
}

<?php

namespace Plutuss\AMember\Tests\Feature;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Clients\AMemberClient;
use Plutuss\AMember\Facades\AMember;
use Plutuss\AMember\Providers\AMemberServiceProvider;
use Plutuss\AMember\Response\Adapter\CollectionReportAdapter;
use Plutuss\AMember\Services\AMemberInterface;
use Plutuss\AMember\Services\AMemberService;
use Plutuss\AMember\Tests\TestCase;

class LaravelIntegrationTest extends TestCase
{
    public function test_provider_and_facade_resolve_the_same_singleton(): void
    {
        $service = $this->app->make(AMemberInterface::class);

        $this->assertInstanceOf(AMemberService::class, $service);
        $this->assertSame($service, $this->app->make('amember.app'));
        $this->assertSame($service, AMember::getFacadeRoot());
    }

    public function test_default_adapter_configuration_is_loaded_without_publishing(): void
    {
        $this->assertSame(CollectionReportAdapter::class, config('amember.type_response.response_class.collection'));
        $this->assertSame('array', config('amember.type_response.default'));
        $this->assertContains(config_path('amember.php'), AMemberServiceProvider::pathsToPublish(AMemberServiceProvider::class));
    }

    public function test_facade_can_make_repeated_requests(): void
    {
        Http::fake(['*' => Http::response(['user_id' => 42], 200)]);

        $result = AMember::users()->getUsers(42);
        AMember::users()->getUsers(43);

        $this->assertSame(['status' => 200, 'data' => ['user_id' => 42]], $result);
        Http::assertSent(fn (Request $request) => strtok($request->url(), '?') === 'https://amember.test/api/users/42'
            && $request->hasHeader('X-API-Key', 'test-key'));
        Http::assertSent(fn (Request $request) => str_starts_with($request->url(), 'https://amember.test/api/users/43?'));
        Http::assertSentCount(2);
    }

    public function test_all_http_methods_use_the_real_laravel_client(): void
    {
        Http::fake(['*' => Http::response(['ok' => true], 201)]);

        foreach (['Get', 'Post', 'Put', 'Delete'] as $method) {
            $result = (new AMemberClient())->setOption('/users', ['active' => 0, 'enabled' => false, 'name' => ''])->{'send' . $method}();
            $this->assertSame(['status' => 201, 'data' => ['ok' => true]], $result);
            Http::assertSent(function (Request $request) use ($method): bool {
                return $request->method() === strtoupper($method)
                    && $request->hasHeader('X-API-Key', 'test-key')
                    && $request['active'] == 0
                    && array_key_exists('enabled', $request->data())
                    && array_key_exists('name', $request->data())
                    && (!in_array($method, ['Post', 'Put'], true)
                        || $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded'));
            });
        }
        Http::assertSentCount(4);
    }

    public function test_fluent_parameters_are_sent_to_laravel_transport(): void
    {
        Http::fake(['*' => Http::response([], 200)]);

        (new AMemberClient())->setOption('/users')->count(12)->page(2)->sort('user_id')->order('desc')
            ->filter(['active' => 0])->nested(['invoices'])->sendGet();

        Http::assertSent(function (Request $request): bool {
            $query = $this->queryParameters($request);
            return $query['_count'] === '12'
                && $query['_page'] === '2'
                && $query['_sort'] === 'user_id'
                && $query['_order'] === 'desc'
                && $query['_filter'] === ['active' => '0']
                && $query['_nested'] === ['invoices'];
        });
    }

    public function test_collection_response_uses_laravel_collection(): void
    {
        config(['amember.type_response.default' => 'collection']);
        Http::fake(['*' => Http::response(['ok' => true], 200)]);

        $result = (new AMemberClient())->setOption('/users')->sendGet();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame(['status' => 200, 'data' => ['ok' => true]], $result->all());
    }

    public function test_json_response_uses_laravel_response_factory(): void
    {
        config(['amember.type_response.default' => 'json']);
        Http::fake(['*' => Http::response(['error' => 'Unauthorized'], 401)]);

        $result = (new AMemberClient())->setOption('/users')->sendGet();

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(['status' => 401, 'data' => ['error' => 'Unauthorized']], $result->getData(true));
    }

    public function test_connection_exception_propagates(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Connection unavailable');
        });

        $this->expectException(ConnectionException::class);
        (new AMemberClient())->setOption('/users')->sendGet();
    }
}

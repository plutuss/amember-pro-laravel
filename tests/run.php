<?php

declare(strict_types=1);

// Minimal transport doubles keep these unit tests independent of Laravel and a live API.
namespace Illuminate\Http\Client {
    class ConnectionException extends \RuntimeException {}

    final class Response
    {
        public function status(): int { return 201; }
        public function json(): array { return ['user_id' => 42]; }
    }

    final class PendingRequest
    {
        private bool $form = false;

        public function __construct(private array $headers) {}

        public function asForm(): self
        {
            $this->form = true;
            return $this;
        }

        public function __call(string $method, array $arguments): Response
        {
            if (!in_array($method, ['get', 'post', 'put', 'delete'], true)) {
                throw new \LogicException('Unexpected HTTP method: ' . $method);
            }

            \Illuminate\Support\Facades\Http::$requests[] = [
                'method' => $method,
                'url' => $arguments[0],
                'params' => $arguments[1],
                'headers' => $this->headers,
                'form' => $this->form,
            ];

            if (\Illuminate\Support\Facades\Http::$exception !== null) {
                throw \Illuminate\Support\Facades\Http::$exception;
            }

            return new Response();
        }
    }
}

namespace Illuminate\Support\Facades {
    final class Http
    {
        public static array $requests = [];
        public static ?\Throwable $exception = null;

        public static function withHeaders(array $headers): \Illuminate\Http\Client\PendingRequest
        {
            return new \Illuminate\Http\Client\PendingRequest($headers);
        }
    }
}

namespace {
    use Illuminate\Http\Client\ConnectionException;
    use Illuminate\Support\Facades\Http;
    use Plutuss\AMember\Clients\AMemberClient;

    $configuration = [
        'amember.amember_url' => 'https://amember.test/api',
        'amember.amember_api_key' => 'test-key',
        'amember.type_response.default' => 'array',
        'amember.type_response.response_class' => [
            'array' => \Plutuss\AMember\Response\Adapter\ArrayReportAdapter::class,
        ],
    ];

    function config(string $key): mixed
    {
        return $GLOBALS['configuration'][$key];
    }

    spl_autoload_register(static function (string $class): void {
        $prefix = 'Plutuss\\AMember\\';
        if (str_starts_with($class, $prefix)) {
            require dirname(__DIR__) . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        }
    });
    require dirname(__DIR__) . '/src/helpers.php';

    function same(mixed $expected, mixed $actual): void
    {
        if ($expected !== $actual) {
            throw new \RuntimeException('Expected ' . var_export($expected, true) . ', received ' . var_export($actual, true));
        }
    }

    function lastRequest(): array
    {
        return Http::$requests[array_key_last(Http::$requests)];
    }

    $tests = [];
    foreach (['Get' => false, 'Post' => true, 'Put' => true, 'Delete' => false] as $verb => $form) {
        $tests[$verb . ' sends headers, payload and adapted response'] = static function () use ($verb, $form): void {
            $client = new AMemberClient();
            $response = $client->setOption('/users', ['login' => 'alice'])->{'send' . $verb}();
            $request = lastRequest();
            same(strtolower($verb), $request['method']);
            same('https://amember.test/api/users', $request['url']);
            same(['X-API-Key' => 'test-key'], $request['headers']);
            same($form, $request['form']);
            same('alice', $request['params']['login']);
            same(['status' => 201, 'data' => ['user_id' => 42]], $response);
        };
    }

    $tests['reusing client replaces endpoint and request payload'] = static function (): void {
        $client = new AMemberClient();
        $client->setOption('/users', ['login' => 'alice'])->sendPost();
        $client->setOption('/products')->sendGet();
        same('https://amember.test/api/products', lastRequest()['url']);
        same(false, array_key_exists('login', lastRequest()['params']));
    };

    $tests['endpoint joining normalizes boundary slashes'] = static function (): void {
        foreach (['https://amember.test/api', 'https://amember.test/api/'] as $baseUrl) {
            $GLOBALS['configuration']['amember.amember_url'] = $baseUrl;
            foreach (['users', '/users'] as $endpoint) {
                (new AMemberClient())->setOption($endpoint)->sendGet();
                same('https://amember.test/api/users', lastRequest()['url']);
            }
        }
    };

    $tests['sending without setOption uses base URL and defaults'] = static function (): void {
        (new AMemberClient())->sendGet();
        same('https://amember.test/api', lastRequest()['url']);
        same(['_format' => 'json', '_count' => 20, '_page' => 0, '_order' => 'asc'], lastRequest()['params']);
    };

    $tests['payload retains zero, false, empty string, arrays and floats'] = static function (): void {
        $payload = ['zero' => 0, 'false' => false, 'empty' => '', 'float' => 1.25, 'array' => [], 'null' => null];
        (new AMemberClient())->setOption('/users', $payload)->sendPost();
        $actual = lastRequest()['params'];
        foreach ($payload as $key => $value) {
            if ($value !== null) {
                same(true, array_key_exists($key, $actual));
                same($value, $actual[$key]);
            }
        }
        same(false, array_key_exists('null', $actual));
    };

    $tests['fluent options and repeated filters retain existing merge semantics'] = static function (): void {
        $client = new AMemberClient();
        same($client, $client->format('json')->count(12)->page(2)->sort('user_id')->order('desc')
            ->filter(['user_id' => 7])->filter(['user_id' => 9, 'active' => 0])
            ->nested(['invoices'])->nested(['access']));
        $client->setOption('/users')->sendGet();
        same([
            '_format' => 'json', '_count' => 12, '_page' => 2, '_sort' => 'user_id', '_order' => 'desc',
            '_filter' => ['user_id' => 7, 'active' => 0], '_nested' => ['access', 'invoices'],
        ], lastRequest()['params']);
    };

    $tests['connection failure propagates original exception'] = static function (): void {
        $exception = new ConnectionException('Connection unavailable');
        Http::$exception = $exception;
        try {
            (new AMemberClient())->setOption('/users')->sendGet();
        } catch (ConnectionException $actual) {
            same($exception, $actual);
            return;
        }
        throw new \RuntimeException('Expected a connection exception');
    };

    $failures = 0;
    foreach ($tests as $name => $test) {
        Http::$requests = [];
        Http::$exception = null;
        $configuration['amember.amember_url'] = 'https://amember.test/api';
        try {
            $test();
            echo "PASS: {$name}\n";
        } catch (\Throwable $exception) {
            ++$failures;
            fwrite(STDERR, "FAIL: {$name}\n{$exception->getMessage()}\n");
        }
    }
    echo count($tests) . " tests, {$failures} failures\n";
    exit($failures === 0 ? 0 : 1);
}

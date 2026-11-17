# aMember and Laravel recipes

[Documentation home](../README.md) · [API reference](api.md) · [Parameters](parameters.md)

All facade examples use:

```php
use Plutuss\AMember\Facades\AMember;
```

IDs and payloads below are examples. Use IDs from your installation and API key permissions appropriate to the operation.

## Check membership access

```php
$result = AMember::auth()->byLoginPass('jane', 'submitted-password');
$access = $result->get('data'); // Default Collection wrapper.

if (($access['ok'] ?? false) === true) {
    $subscriptions = $access['subscriptions'] ?? [];
}
```

Check both the upstream `status` and the payload's `ok` result in your application. A successful transport response alone does not establish valid membership access. This method does not create a Laravel authentication session.

Other checks: `byUsername('jane')`, `byEmailAddress('jane@example.com')`, and `byLoginPassIp('jane', 'submitted-password', '127.0.0.1')`.

```php
// Sends a recovery email through aMember.
$result = AMember::auth()->restorePassword('jane');
```

## Grant, update, and remove subscription access

```php
$created = AMember::access()->setAccess([
    'user_id' => 42,
    'product_id' => 7,
    'begin_date' => '2026-01-01',
    'expire_date' => '2026-12-31',
]);

$updated = AMember::access()->updateAccess(51, ['expire_date' => '2027-12-31']);
$removed = AMember::access()->deleteAccess(51); // Access record ID, not user ID.
```

## Products with billing plans and categories

```php
$result = AMember::products()->setProducts([
    'title' => 'Monthly membership',
    'description' => 'Member access',
    'nested' => [
        'billing-plans' => [[
            'title' => 'Monthly plan',
            'first_price' => '10.00',
            'first_period' => '1m',
            'second_price' => '10.00',
            'second_period' => '1m',
            'rebill_times' => 99999,
            'currency' => 'USD',
            'qty' => 1,
            'variable_qty' => 0,
        ]],
        'product-product-category' => [['product_category_id' => 2]],
    ],
]);
```

The API example uses 99999 for recurring billing until cancellation. Adapt billing fields to your installation; creating a product does not charge a customer. See the [official examples](https://docs.amember.com/REST_API_examples/).

## Invoice and related records

`setInvoice($data)` forwards the invoice payload. Put related `invoice-items`, `invoice-payments`, and `access` records under the `nested` key. The complete invoice field set depends on your billing scenario; use the [official invoice example](https://docs.amember.com/REST_API_examples/) when constructing it.

```php
$invoice = AMember::invoice()->getInvoice(8);
$items = AMember::invoiceItems()->where('invoice_id', 8)->get();
$payments = AMember::payment()->where('invoice_id', 8)->invoicePayments();
$refunds = AMember::invoice()->where('invoice_id', 8)->getInvoiceRefunds();
```

These reads retrieve records; they do not trigger charging or refund processing.

## Array, XML, and serialized responses

For array examples, set `AMEMBER_TYPE_RESPONSE=array` in configuration before resolving package services.

```php
use Plutuss\AMember\Clients\AMemberClient;

$xml = (new AMemberClient())->setOption('/users')->format('xml')->sendGet();
$xmlBody = $xml['data']; // Original XML string.

$serialized = (new AMemberClient())->setOption('/users')->format('serialize')->sendGet();
$serializedBody = $serialized['data']; // Original serialized string.
```

## Custom controller requests

```php
use Plutuss\AMember\Clients\AMemberClient;

$result = (new AMemberClient())
    ->setOption('/users')
    ->where('user_id', 42)
    ->count(1)
    ->sendGet();
```

The client also exposes `sendPost()`, `sendPut()`, and `sendDelete()`. POST and PUT use form encoding. You can use the documented POST method override when required by a proxy:

```php
$result = (new AMemberClient())
    ->setOption('/users/42', ['_method' => 'PUT', 'name_f' => 'Jane'])
    ->sendPost();
```

## Handle transport errors

```php
use Illuminate\Http\Client\ConnectionException;

try {
    $result = AMember::users()->getUsers(42);
    if ($result->get('status') >= 400) {
        // Handle the upstream HTTP error in your application.
    }
} catch (ConnectionException $exception) {
    // Handle timeout, DNS, or connection failures in your application.
}
```

## Fake the API in a Laravel test

Inside a Laravel PHPUnit test case, with the package provider loaded:

```php
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Plutuss\AMember\Clients\AMemberClient;

config([
    'amember.amember_url' => 'https://amember.test/api',
    'amember.amember_api_key' => 'test-key',
    'amember.type_response.default' => 'array',
]);

Http::preventStrayRequests();
Http::fake(['amember.test/*' => Http::response(['user_id' => 42], 200)]);

$result = (new AMemberClient())->setOption('/users/42')->sendGet();

$this->assertSame(200, $result['status']);
$this->assertSame(42, $result['data']['user_id']);
Http::assertSent(fn (Request $request) => $request->method() === 'GET'
    && $request->hasHeader('X-API-Key', 'test-key'));
```

Set configuration before the first package request: the response adapter caches its configuration. For this package's Testbench setup, see [tests/TestCase.php](../tests/TestCase.php).

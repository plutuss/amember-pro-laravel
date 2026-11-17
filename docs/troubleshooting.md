# Troubleshooting and behavior notes

[Documentation home](../README.md) · [API reference](api.md)

## Installation or dependency resolution fails

Use a PHP version supported by your Laravel version. The current package constraints allow Laravel 10, 11, 12, and 13. Run `composer show plutuss/amember-pro-laravel` to inspect your installed version and `composer why-not plutuss/amember-pro-laravel VERSION` with the actual desired release version to identify conflicts. Source checkout changes may be newer than the latest published tag.

## API endpoint returns 404

Check that `AMEMBER_URL` includes `/api` and the aMember installation directory, for example `https://members.example.com/amember/api`. Ensure the API module is enabled. Use the endpoint reference to distinguish `/invoices` from `/invoice-payments` and `/invoice-refunds`.

## Authorization fails

Check the API key and permissions in aMember's Remote Api Permissions settings. The client sends `X-API-Key`. Ensure any reverse proxy forwards this header. Inspect the upstream `status` and error payload; don't assume every failure uses the same HTTP code.

## Environment changes have no effect

Run `php artisan config:clear` in the Laravel application. Set configuration before creating services or sending requests. Static service/client instances and the response adapter can retain previous settings. Restart long-running queue workers or application processes after configuration changes.

## Publishing is unavailable or the facade cannot resolve

The provider is `Plutuss\AMember\Providers\AMemberServiceProvider`. Laravel package auto-discovery normally registers it. If your application disables discovery, register this provider using your Laravel version's provider registration mechanism. Run `php artisan package:discover` after dependency installation when necessary.

## First page is skipped

Pages start at zero. `paginate(50, 0)` requests the first page. The maximum page size is 1000. Inspect `data` for the server's `_total` value rather than assuming it exists at the wrapper's top level.

## A filter was not replaced

`filter()` keeps an earlier value when the same field appears in a later call. `where()` replaces that field. Older facade service accessors retain mutable state; use a fresh concrete service or a fresh dedicated resource accessor for independent filters. See [builder lifetime](parameters.md#builder-lifetime).

## XML or serialized responses are strings

This is expected. The client preserves their wire bodies in `data`; it only decodes JSON. The `AMEMBER_TYPE_RESPONSE` setting controls the wrapper independently of `format()`. Serialized responses are not automatically unserialized.

## The JSON response has HTTP 200 even when the API failed

The JsonResponse adapter puts the upstream status in the body under `status` and currently leaves the outer response at HTTP 200. Set the outer status explicitly if you return it from your controller:

```php
// With AMEMBER_TYPE_RESPONSE=json:
use Plutuss\AMember\Facades\AMember;

$result = AMember::users()->getUsers(42);
$result->setStatusCode($result->getData(true)['status']);
return $result;
```

## Check Access ignores filters or a selected XML format

This controller always returns JSON and accepts its own login/password/email/IP inputs. The package sends these calls with GET, including password recovery. Treat `restorePassword()` as an operation that sends an email.

## Connection fails or the response is not JSON

Connection failures throw `Illuminate\Http\Client\ConnectionException`. HTTP 4xx/5xx responses are adapted instead of automatically throwing. The client does not currently validate JSON content: an HTML proxy error or malformed JSON can produce null in `data`. Check the upstream service and proxy logs without exposing credentials.

## Tests cannot start

Install PHP and Composer. In a source checkout, run `composer install` to resolve development dependencies and create a local lock file, then `composer test` and `composer test:unit`. The library does not commit its development lock file. Integration tests need Laravel dependencies; `php tests/run.php` is the standalone suite. Tests use fake transport and do not require live API credentials.

## What is not included

This package does not provide Laravel login sessions, automatic retries, a universal CRUD guarantee, or payment-gateway charge/refund execution. It does not validate every resource-specific field. Use fields supported by your aMember version, customizations, and API permissions.

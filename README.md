# aMember Pro REST API client for Laravel

[![Packagist version](https://img.shields.io/packagist/v/plutuss/amember-pro-laravel.svg)](https://packagist.org/packages/plutuss/amember-pro-laravel)
[![Packagist downloads](https://img.shields.io/packagist/dt/plutuss/amember-pro-laravel.svg)](https://packagist.org/packages/plutuss/amember-pro-laravel)
[![Tests](https://github.com/plutuss/amember-pro-laravel/actions/workflows/tests.yml/badge.svg)](https://github.com/plutuss/amember-pro-laravel/actions/workflows/tests.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

Integrate **aMember Pro** with **Laravel** using a PHP REST API client with a Laravel facade, configuration auto-discovery, fluent filters, pagination, and response adapters. Manage members, products, invoices, subscription access, payment records, and affiliate payouts from your Laravel application.

**Package:** `plutuss/amember-pro-laravel` · **Namespace:** `Plutuss\AMember` · [Русское руководство](docs/README.ru.md)

## Documentation

- [Requirements](#requirements)
- [Installation and configuration](#installation-and-configuration)
- [Quick start](#quick-start)
- [API methods and endpoints](docs/api.md)
- [Filters, pagination, and parameters](docs/parameters.md)
- [Recipes and Laravel testing](docs/examples.md)
- [Response formats](#response-formats)
- [Troubleshooting and limitations](docs/troubleshooting.md)
- [Contributing](CONTRIBUTING.md)
- [Repository topics and package discovery](docs/discoverability.md)

## Features

- Laravel service provider and `AMember` facade.
- User creation, updates, deletion, groups, notes, and consent records.
- Products, billing plans, product categories, and category relations.
- Invoices, invoice items, payment records, and refunds.
- Subscription access creation, updates, deletion, and access logs.
- Check Access by login, email, password, and IP; password recovery requests.
- Saved forms and affiliate payout records.
- Fluent query parameters and custom REST requests.
- Array, Laravel Collection, and JsonResponse wrappers; JSON, XML, and serialized wire formats.
- PHPUnit / Orchestra Testbench integration tests and a standalone regression suite.

Reading a payment or refund record does not initiate a payment or refund. Operations depend on the aMember API module and the permissions granted to your API key.

## Requirements

The Composer constraints target Laravel 10, 11, and 12. The CI matrix is configured as follows; consult the workflow results for execution status.

| Laravel | PHP in CI | Orchestra Testbench |
| --- | --- | --- |
| 10 | 8.1 | 8 |
| 11 | 8.2 | 9 |
| 12 | 8.3 | 10 |

Use a PHP version supported by your Laravel version. An aMember Pro installation with the API module enabled and a permitted API key is required for real requests. See the [official API setup instructions](https://docs.amember.com/REST/#enabling-of-rest-api).

## Installation and configuration

```shell
composer require plutuss/amember-pro-laravel
```

Laravel discovers the service provider automatically. Configuration defaults are loaded without publishing. To customize the configuration file:

```shell
php artisan vendor:publish --provider="Plutuss\AMember\Providers\AMemberServiceProvider"
```

Set these values in your Laravel application's `.env`:

```dotenv
AMEMBER_URL=https://members.example.com/amember/api
AMEMBER_API_KEY=replace-with-your-api-key
AMEMBER_TYPE_RESPONSE=collection
```

`AMEMBER_URL` must include the installation path and `/api`. The key is sent in the `X-API-Key` header. Choose `collection`, `array`, or `json` for the response wrapper.

After changing environment settings in an application that caches configuration:

```shell
php artisan config:clear
```

## Quick start

```php
use Plutuss\AMember\Facades\AMember;

// Default wrapper: Illuminate\Support\Collection.
$result = AMember::users()->getUsers();
$httpStatus = $result->get('status');
$apiData = $result->get('data');

// Fetch one user.
$user = AMember::users()->getUsers(42);

// Filter and paginate: page numbers start at zero.
$users = AMember::users()
    ->where('email', '%@example.com')
    ->paginate(50, 0)
    ->sort('user_id')
    ->order('desc')
    ->getUsers();

// Read related billing plans.
$products = AMember::products()->nested(['billing-plans'])->products();
```

Create and update a member:

```php
use Plutuss\AMember\Facades\AMember;

$created = AMember::users()->addUsers(
    login: 'jane',
    pass: 'replace-with-a-unique-password',
    email: 'jane@example.com',
    params: ['name_f' => 'Jane', 'name_l' => 'Doe'],
);

$updated = AMember::users()->updateUser(42, [
    'name_f' => 'Jane',
    'name_l' => 'Smith',
]);
```

Dedicated resource builders make common lookups shorter:

```php
use Plutuss\AMember\Facades\AMember;

$notes = AMember::userNotes()->where('user_id', 42)->get();
$groups = AMember::userGroups()->get();
$plan = AMember::billingPlans()->get(7);
$categories = AMember::productCategories()->get();
```

See the [complete endpoint reference](docs/api.md) and [copyable recipes](docs/examples.md).

## Response formats

Every configured adapter wraps the result as `status` (the upstream HTTP status) and `data` (the API body):

```php
// With AMEMBER_TYPE_RESPONSE=array:
[
    'status' => 200,
    'data' => [/* decoded aMember JSON payload */],
]
```

| Configuration | Returned PHP type | Access |
| --- | --- | --- |
| `collection` (default) | `Illuminate\Support\Collection` | `$result->get('data')` |
| `array` | `array` | `$result['data']` |
| `json` | `Illuminate\Http\JsonResponse` | `$result->getData(true)['data']` |

The JSON adapter includes the upstream status inside the body; the outer JsonResponse currently uses HTTP 200. Set the outer status yourself when forwarding it from a controller. HTTP error responses are returned through the same adapters; connection failures throw `Illuminate\Http\Client\ConnectionException`.

`format()` selects the upstream wire format independently of the adapter:

- `json`: decoded JSON in `data` (default).
- `xml`: original XML string in `data`.
- `serialize`: original PHP serialized string in `data`; the client does not unserialize it.

Check Access always decodes JSON and omits general query parameters, regardless of `format()`.

## Development and tests

From a source checkout, resolve the development dependencies and run both suites:

```shell
composer update
composer test
composer test:unit
```

The existing lock file predates the Testbench dependencies; `composer update` must refresh it before a reproducible `composer install` can be used. PHP and Composer are required locally. The integration suite boots Laravel with Testbench and uses `Http::fake()`; neither suite needs a live aMember server.

## Support and upstream documentation

- [Report a reproducible bug](https://github.com/plutuss/amember-pro-laravel/issues/new?template=bug_report.yml)
- [Request a feature](https://github.com/plutuss/amember-pro-laravel/issues/new?template=feature_request.yml)
- [aMember Pro REST API](https://docs.amember.com/REST/)
- [Official API examples](https://docs.amember.com/REST_API_examples/)
- [Packagist package](https://packagist.org/packages/plutuss/amember-pro-laravel)

Independent integration package; aMember Pro and Laravel are their respective projects. Licensed under the [MIT license](LICENSE.md).

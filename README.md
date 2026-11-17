## Installed packages

## Laravel:

- [GitHub](https://github.com/plutuss/amember-api-laravel).
- [AMember Pro Web API](https://docs.amember.com/REST/).

```shell
 composer require plutuss/amember-pro-laravel
```

```shell
php artisan vendor:publish --provider="Plutuss\AMember\Providers\AMemberServiceProvider"
```

## .env

- [How to get aMember API Key](https://help.birdsend.co/article/show/104240-how-to-get-amember-api-key)

```dotenv
AMEMBER_URL=http://g00dsdw5vib.amdemo.com/api
AMEMBER_API_KEY=F1dbbZd3453sdfneqdsfhw
```


```dotenv
#default collection
#collection|array|json
AMEMBER_TYPE_RESPONSE=collection
```

## Use Facade AMember

- auth()
- invoice()
- payment()
- users()
- products()
- refunds()
- forms()
- access()
- affiliate()

```php
<?php

class AMemberController extends Controller
{
    public function index()
    {
      \Plutuss\AMember\Facades\AMember::users()->getUsers();
    }

    public function invoice_all()
    {
      \Plutuss\AMember\Facades\AMember::invoice()->getInvoice();
    }

    public function invoice_by_id()
    {
      \Plutuss\AMember\Facades\AMember::invoice()->getInvoice(8);
    }

    public function auth()
    {
          \Plutuss\AMember\Facades\AMember::auth()->byLoginPass(
            login: 'admin',
            pass: '12341234'
        );
    }

    public function store()
    {

          \Plutuss\AMember\Facades\AMember::users()->addUsers(
            login: 'admin',
            pass: '12341234',
            email: 'admin@admin.com',
            params: [
                'name_f' => 'John',
                'name_l' => 'Smith',
                ...
              ]
          );

    }

    public function update()
    {

          \Plutuss\AMember\Facades\AMember::users()
            ->updateUser(
              id: 8,
              fieldsAndValue: [
                'email' => 'max@admin.com',
                'name_f' => 'Max',
                'name_l' => 'Smith',
              ]
          );

    }



}

```

### Parameters

You can pass additional parameters to control output: [Docs](https://docs.amember.com/REST/#fetching-list-of-users-via-web-api)

| Method   | Description                                                                                                                |
| -------- | -------------------------------------------------------------------------------------------------------------------------- |
| format() | Either: json (default), xml or serialize                                                                                   |
| count()  | Number of records per page (default: 20, max: 1000)                                                                        |
| page()   | Page of output (default: 0 - the first page)                                                                               |
| sort()   | Sort records based on a specified field                                                                                    |
| order()  | Sort direction. Either asc (default) or desc                                                                               |
| filter() | Adds a WHERE condition for FIELDNAME.                                                                                      |
|          | If search value contains % - it is considered as pattern for SQL LIKE expression, else SQL scondition is used.             |
|          | If multiple filters are provided, it will be concatenated into an SQL AND expression.                                      |
| nested() | Requests to include nested records into dataset. nested[]=invoices&nested[]=access                                         |
|          | It will add user's invoices and access records into output. List of available nested tables is unique to each record type. |

```php
<?php

    public function index()
    {
      \Plutuss\AMember\Facades\AMember::users()->count(12)->page(2)->getUsers();
    }
```

## It is also possible to make a custom query

```php
<?php

    public function index()
    {
      (new AMemberClient())->setOption('/users')
          ->format('json')
          ->filter(['user_id' => 1])
          ->count(12)
          ->sendGet();

        // Or you can
        AMemberClient::getInstance()
          ->setOption('/users')
          ->format('json')
          ->filter(['user_id' => 1])
          ->count(12)
          ->sendGet();
    }

    public function auth()
    {
      (new AMemberClient())->setOption('/check-access/by-login-pass', [
              'login' => 'admin',
              'pass' => '12341234',
          ])->sendPost();

      // Or you can
      AMemberClient::getInstance()
        ->setOption('/check-access/by-login-pass', [
              'login' => 'admin',
              'pass' => '12341234',
        ])->sendPost();

    }
```

## Tests

The Laravel integration suite uses [Orchestra Testbench](https://packages.tools/testbench) and PHPUnit. It boots a Laravel application with the package provider and uses `Http::fake()` to prevent real API requests.

Install development dependencies and run the suites (PHP 8.1 or newer):

```shell
composer update
composer test
composer test:unit
```

`composer update` refreshes the existing lock file with the new development dependencies. After that, use `composer install` for reproducible installs.

- `composer test`: provider bindings, facade requests, configuration, HTTP methods, fluent parameters, response adapters, and connection failures using Laravel.
- `composer test:unit`: the standalone regression suite without Laravel dependencies.

GitHub Actions runs both suites against Laravel 10 / Testbench 8 / PHP 8.1, Laravel 11 / Testbench 9 / PHP 8.2, and Laravel 12 / Testbench 10 / PHP 8.3.

## REST API compatibility

`format('json'|'xml'|'serialize')` selects the aMember wire format. JSON is decoded; XML and PHP serialized responses are returned as raw strings in `data` inside the configured array, collection, or JSON response wrapper. Serialized responses are never passed to `unserialize()`.

Query options are validated before sending: `count` accepts 1–1000, `page` accepts zero or greater, and `order` accepts `asc` or `desc`. Invalid values throw `InvalidArgumentException`.

Check Access methods use GET, always decode JSON, and omit general query options because this controller ignores them. This includes `restorePassword`, which sends the password recovery email.

```php
use Plutuss\AMember\Facades\AMember;

AMember::users()->getUserGroups();
AMember::users()->getUserGroups(7);
AMember::access()->deleteAccess(51);

// Include related records when reading: sends _nested[].
AMember::products()->nested(['billing-plans'])->products();

// Create related records: pass nested (without the underscore) in the payload.
AMember::products()->setProducts([
    'title' => 'Example',
    'nested' => [
        'billing-plans' => [[
            'first_price' => '10.00',
            'first_period' => '1m',
            'currency' => 'USD',
            'qty' => 1,
        ]],
        'product-product-category' => [['product_category_id' => 2]],
    ],
]);
```

Invoice creation supports the same `nested` payload with `invoice-items`, `invoice-payments`, and `access`. See the [REST documentation](https://docs.amember.com/REST/) and [official examples](https://docs.amember.com/REST_API_examples/).

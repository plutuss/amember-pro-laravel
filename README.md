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

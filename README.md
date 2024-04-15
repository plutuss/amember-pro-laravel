## Installed packages

Laravel:

- [GitHub](https://github.com/plutuss/amember-api-laravel).
- [AMember Pro Web API](https://docs.amember.com/REST/).

```shell
 composer require plutuss/amember-api-laravel
```

```shell
php artisan vendor:publish --provider="Plutuss\AMember\Providers\AMemberServiceProvider"
```

.env

```dotenv
AMEMBER_URL=http://g00dsdw5vib.amdemo.com/api
AMEMBER_API_KEY=F1dbbZd3453sdfneqdsfhw
```

## Use

Use Facades:

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
    
 
    
}

```

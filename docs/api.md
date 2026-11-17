# API methods and endpoints

[Documentation home](../README.md) · [Parameters](parameters.md) · [Recipes](examples.md)

All paths below are relative to `AMEMBER_URL`. Import `Plutuss\AMember\Facades\AMember` before using the facade. Read methods accepting an optional `$id` fetch a list when omitted and append `/{id}` when provided. Check Access parameters are passed as GET query fields. API key permissions still determine which calls are available.

The reference describes the package's implemented operations. A listed server controller does not imply that every HTTP verb is supported. See the [upstream API](https://docs.amember.com/REST/) for server behavior.

## Dedicated resource builders

These accessors return a fresh `AMemberResourceService` with `get(?int $id = null, array $params = [])`. They support all [fluent parameters](parameters.md).

| Facade accessor | GET endpoint |
| --- | --- |
| `AMember::userGroups()->get($id)` | `/user-groups` or `/user-groups/{id}` |
| `AMember::userNotes()->get($id)` | `/user-notes` or `/user-notes/{id}` |
| `AMember::userConsent()->get($id)` | `/user-consent` or `/user-consent/{id}` |
| `AMember::billingPlans()->get($id)` | `/billing-plans` or `/billing-plans/{id}` |
| `AMember::productCategories()->get($id)` | `/product-category` or `/product-category/{id}` |
| `AMember::productCategoryRelations()->get($id)` | `/product-product-category` or `/product-product-category/{id}` |
| `AMember::invoiceItems()->get($id)` | `/invoice-items` or `/invoice-items/{id}` |

## Service methods

Legacy method names are preserved, including `addUsers`, `deletingUser`, and `setProducts`. The following tables include all public methods declared by the service interfaces. Each returns the configured array, Collection, or JsonResponse wrapper.

### Users

Accessor: `AMember::users()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `addUsers(string $login, string $pass, string $email, array $params = [])` | POST | `/users` |
| `updateUser(int $id, array $fieldsAndValue)` | PUT | `/users/{id}` |
| `deletingUser(int $id)` | DELETE | `/users/{id}` |
| `getUsers(?int $id = null)` | GET | `/users[/{id}]` |
| `getUserConsent(?int $id = null)` | GET | `/user-consent[/{id}]` |
| `getUserGroups(?int $id = null)` | GET | `/user-groups[/{id}]` |
| `getUserNotes(?int $id = null)` | GET | `/user-notes[/{id}]` |


### Auth

Accessor: `AMember::auth()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `byLoginPassIp(string $login, string $pass, string $ip)` | GET | `/check-access/by-login-pass-ip` |
| `byLoginPass(string $login, string $pass)` | GET | `/check-access/by-login-pass` |
| `byUsername(string $login)` | GET | `/check-access/by-login` |
| `byEmailAddress(string $email)` | GET | `/check-access/by-email` |
| `restorePassword(string $login)` | GET | `/check-access/send-pass` |


### Access

Accessor: `AMember::access()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `getAccess(?int $id = null)` | GET | `/access[/{id}]` |
| `getAccessLog(?int $id = null)` | GET | `/access-log[/{id}]` |
| `setAccess(array $data)` | POST | `/access` |
| `updateAccess(int $id, array $data)` | PUT | `/access/{id}` |
| `deleteAccess(int $id)` | DELETE | `/access/{id}` |


### Invoice

Accessor: `AMember::invoice()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `getInvoiceItems(?int $id = null)` | GET | `/invoice-items[/{id}]` |
| `getInvoice(?int $id = null)` | GET | `/invoices[/{id}]` |
| `setInvoice(array $data)` | POST | `/invoices` |
| `updateInvoice(int $id, array $data)` | PUT | `/invoices/{id}` |
| `getInvoicePayments(?int $id = null)` | GET | `/invoice-payments[/{id}]` |
| `getAccess(?int $id = null)` | GET | `/access[/{id}]` |
| `getInvoiceRefunds(?int $id = null)` | GET | `/invoice-refunds[/{id}]` |


### Product

Accessor: `AMember::products()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `products(?int $id = null)` | GET | `/products[/{id}]` |
| `setProducts(array $data)` | POST | `/products` |
| `updateProducts(int $id, array $data)` | PUT | `/products/{id}` |
| `billingPlans(?int $id = null)` | GET | `/billing-plans[/{id}]` |
| `productCategory(?int $id = null)` | GET | `/product-category[/{id}]` |
| `productCategoryRelations(int $id = null)` | GET | `/product-product-category[/{id}]` |


### Payment

Accessor: `AMember::payment()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `invoicePayments(?int $id = null)` | GET | `/invoice-payments[/{id}]` |


### Refund

Accessor: `AMember::refunds()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `invoiceRefunds(?int $id = null)` | GET | `/invoice-refunds[/{id}]` |


### Affiliate

Accessor: `AMember::affiliate()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `affPayouts(?int $id = null)` | GET | `/aff-payouts[/{id}]` |
| `affPayoutDetails(?int $id = null)` | GET | `/aff-payout-details[/{id}]` |


### Form

Accessor: `AMember::forms()`

| Method signature | HTTP | Endpoint |
| --- | --- | --- |
| `savedForms(?int $id = null)` | GET | `/saved-forms[/{id}]` |

## Low-level client

`Plutuss\AMember\Clients\AMemberClient` can access your installation's custom controllers:

| Method | Purpose |
| --- | --- |
| `setOption(string $url, array $params = [])` | Select relative endpoint and replace endpoint payload |
| `sendGet()` | Send GET |
| `sendPost()` | Send form-encoded POST |
| `sendPut()` | Send form-encoded PUT |
| `sendDelete()` | Send DELETE |
| `getInstance()` | Access a static client instance; options persist |

Use `new AMemberClient()` for independent queries. Dedicated `AMemberResourceService` builders require an endpoint in their constructor; obtain them from the named resource accessors rather than calling the inherited `getInstance()`.

POST `_method=PUT` and `_method=DELETE` are available through the low-level payload when your server requires a method override. See [examples](examples.md#custom-controller-requests).

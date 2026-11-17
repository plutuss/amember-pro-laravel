# Filters, pagination, and request parameters

[Documentation home](../README.md) · [API reference](api.md) · [Examples](examples.md)

Import the facade in each PHP file that uses it:

```php
use Plutuss\AMember\Facades\AMember;
```

## Fluent options

These methods are available on the client, existing services, and dedicated resource builders.

| Method | API parameter | Default | Behavior |
| --- | --- | --- | --- |
| `format(string $format)` | `_format` | `json` | Accepts `json`, `xml`, `serialize` |
| `count(int $count)` | `_count` | `20` | Accepts 1–1000 |
| `page(int $page)` | `_page` | `0` | Accepts zero or greater |
| `paginate(int $count = 20, int $page = 0)` | `_count`, `_page` | `20`, `0` | Sets both pagination values |
| `sort($sort)` | `_sort` | Omitted | Field name |
| `order(string $order)` | `_order` | `asc` | Accepts `asc` or `desc` |
| `filter(array $filter)` | `_filter` | Omitted | Merges filter fields; previously set fields win on duplicate keys |
| `where(string $field, string\|int\|float\|bool\|null $value)` | `_filter[field]` | Omitted | Sets or replaces one filter field |
| `nested(array $nested)` | `_nested` | Omitted | Adds related tables for reads |
| `parameters(array $params)` | Additional request fields | None | Merges extra fields; latest call wins for the same extra field |

Invalid format, count, page, or order values throw `InvalidArgumentException` before a request is sent. Zero, false, and empty string payload values are retained. Top-level null values are omitted when general parameters are initialized. How a value is encoded on the wire depends on the HTTP method.

## Search and filters

```php
$users = AMember::users()
    ->where('name_l', 'Sm%')
    ->where('status', 1)
    ->paginate(50, 0)
    ->sort('user_id')
    ->order('desc')
    ->getUsers();
```

Different filter fields are combined using AND; `%` requests pattern matching. Field availability depends on the resource. Choose `where()` to replace an existing condition:

```php
$notes = AMember::userNotes()
    ->where('user_id', 12)
    ->where('user_id', 42)
    ->get(); // user_id = 42
```

`filter(['user_id' => 12])->filter(['user_id' => 42])` retains 12 for backward compatibility.

## Reading related records versus creating them

`nested()` controls inclusion of related records in a read and sends `_nested`. The `nested` payload without an underscore creates related records during supported writes. These have different purposes.

```php
$products = AMember::products()
    ->nested(['billing-plans', 'product-product-category'])
    ->products();
```

See [nested creation examples](examples.md#products-with-billing-plans-and-categories).

## Additional fields and precedence

```php
$result = AMember::userNotes()
    ->parameters(['custom_option' => 'value'])
    ->get(null, ['another_option' => 'value']);
```

Only send extra fields supported by your aMember installation or custom controller. `parameters()` does not enable new server operations.

Values are merged in this order, with later sources taking priority:

1. Fields accumulated through `parameters()`.
2. Fields supplied directly to the endpoint (`setOption`, `get`, `setProducts`, etc.).
3. General fluent options such as `_format`, `_count`, and `_filter`.

Use the dedicated fluent methods to configure reserved options, rather than placing reserved `_...` keys in `parameters()`. Check Access sends only its own login, password, email, and IP arguments; it ignores additional fields and general query options.

## Builder lifetime

`AMember::userNotes()`, `userGroups()`, `userConsent()`, `billingPlans()`, `productCategories()`, `productCategoryRelations()`, and `invoiceItems()` create fresh resource builders. Reusing one builder retains its options.

The older service accessors (`users()`, `products()`, etc.) use static instances and can retain options. Use a new concrete service for an independent query, especially in long-running workers:

```php
use Plutuss\AMember\Services\Users\AMemberUserService;

$firstPage = (new AMemberUserService())->paginate(50, 0)->getUsers();
$unfiltered = (new AMemberUserService())->getUsers();
```

# Contributing

Thanks for helping improve the aMember Pro Laravel client.

## Development setup

Use a PHP version supported by the Laravel version under test and install Composer. From a source checkout:

```shell
composer install
composer test
composer test:unit
```

This library ignores its local development lock file. The first `composer install` resolves dependencies; subsequent installs reuse the local lock. Use `composer update` to refresh the development environment. Consuming Laravel applications manage their own lock files.

Integration tests extend `Plutuss\AMember\Tests\TestCase`, boot Laravel through Orchestra Testbench, and use `Http::fake()`. Never point automated tests at a production aMember installation. CI selects Testbench 8, 9, and 10 for the configured Laravel 10, 11, and 12 matrix.

## Adding or fixing API support

- Link to the official aMember documentation for the endpoint or behavior.
- Preserve existing public method names and argument behavior unless a breaking change is intentional and documented.
- Add meaningful tests for HTTP method, endpoint, payload, response format, and failure behavior as needed.
- Update the relevant service interface, facade declarations, and [API reference](docs/api.md).
- Keep `_nested` read options separate from `nested` creation payloads.
- Avoid assuming that every controller supports every HTTP method.

## Pull requests

Explain the concrete problem, resulting behavior, and how you verified it. State when a test could not be run. Use [bug reports](https://github.com/plutuss/amember-pro-laravel/issues/new?template=bug_report.yml) for reproducible defects and [feature requests](https://github.com/plutuss/amember-pro-laravel/issues/new?template=feature_request.yml) for proposed capabilities.

Do not include real API keys, passwords, or customer data in examples, logs, test fixtures, or issue attachments. Contributions are provided under the repository's [MIT license](LICENSE.md).

Laravel 10 and 11 CI jobs permit advisory-affected test dependencies only to verify legacy compatibility in isolated runners. Laravel 12 keeps advisory blocking enabled; this exception does not change consuming applications or package Composer policy.

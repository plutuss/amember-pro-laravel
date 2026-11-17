# Package discovery and repository metadata

[Documentation home](../README.md)

## Composer and Packagist

The package name is `plutuss/amember-pro-laravel`. Its Composer metadata includes a searchable description, relevant keywords, homepage, documentation, issue tracker, and source links. The main README links to the installation guide, endpoint reference, English and Russian usage examples.

The Composer keywords describe aMember integration, Laravel, PHP, membership, subscriptions, products, invoices, payments, access control, and affiliate payouts. They are metadata for package discovery; they do not claim extra API capabilities. See the [Composer keyword schema](https://getcomposer.org/doc/04-schema.md#keywords).

After publishing these source changes, ensure the Packagist listing uses the correct repository and its update webhook is connected. Publish a release tag only after dependency resolution, tests, and version selection have been completed. The next tag must reflect the project's release policy and actual changes; this update does not create a version tag or release.

## GitHub About settings

These are prepared values to apply in the repository's **About → Edit repository metadata** settings. Files in the repository do not automatically update GitHub topics.

Description:

```text
Laravel REST API client for aMember Pro: members, subscriptions, products, invoices, payments, access control and affiliate payouts.
```

Website:

```text
https://packagist.org/packages/plutuss/amember-pro-laravel
```

Topics (20, all lowercase):

```text
amember amember-pro amember-api laravel laravel-package php api-client rest-api rest-client membership membership-management subscriptions subscription-management access-control invoices payments refunds billing affiliate composer-package
```

GitHub permits up to 20 topics. See [classifying a repository with topics](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/classifying-your-repository-with-topics).

If you maintain the repository using GitHub CLI, apply the metadata with:

```shell
gh repo edit plutuss/amember-pro-laravel \
  --description "Laravel REST API client for aMember Pro: members, subscriptions, products, invoices, payments, access control and affiliate payouts." \
  --homepage "https://packagist.org/packages/plutuss/amember-pro-laravel" \
  --add-topic "amember,amember-pro,amember-api,laravel,laravel-package,php,api-client,rest-api,rest-client,membership,membership-management,subscriptions,subscription-management,access-control,invoices,payments,refunds,billing,affiliate,composer-package"
```

Check existing topics first: remove unrelated topics if adding this set would exceed the limit. GitHub topics are separate from Git version tags and Packagist releases.

## Documentation maintenance

When adding an endpoint or parameter, update:

1. The service interface and implementation.
2. The facade declaration if adding a new accessor.
3. [API methods](api.md), [parameters](parameters.md), and the relevant [examples](examples.md).
4. The integration tests and README feature list where applicable.

Keep examples runnable with placeholder credentials. Use the canonical repository `https://github.com/plutuss/amember-pro-laravel` in links. Avoid adding unrelated keywords, invented support claims, or fabricated downloads and test results.

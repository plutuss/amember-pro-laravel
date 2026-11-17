# aMember Pro для Laravel — PHP-клиент REST API

Пакет `plutuss/amember-pro-laravel` связывает Laravel с aMember Pro: пользователи, подписки и доступ, продукты и тарифы, счета, записи платежей и возвратов, партнёрские выплаты. Есть фасад, фильтры, пагинация и тесты с Orchestra Testbench.

[English documentation](../README.md) · [Все методы API](api.md) · [Параметры](parameters.md) · [Примеры](examples.md) · [Решение проблем](troubleshooting.md)

## Установка

```shell
composer require plutuss/amember-pro-laravel
```

Ограничения зависимостей рассчитаны на Laravel 10–12. Выберите PHP, совместимый с вашей версией Laravel. В aMember включите модуль API и создайте ключ с нужными разрешениями в Remote Api Permissions.

В `.env` Laravel-приложения:

```dotenv
AMEMBER_URL=https://members.example.com/amember/api
AMEMBER_API_KEY=replace-with-your-api-key
AMEMBER_TYPE_RESPONSE=collection
```

Провайдер регистрируется автоматически. Публикация конфигурации нужна только для её изменения:

```shell
php artisan vendor:publish --provider="Plutuss\AMember\Providers\AMemberServiceProvider"
php artisan config:clear
```

## Первые запросы

```php
use Plutuss\AMember\Facades\AMember;

$result = AMember::users()->getUsers(42);
$status = $result->get('status');
$user = $result->get('data');

$notes = AMember::userNotes()
    ->where('user_id', 42)
    ->paginate(50, 0)
    ->get();

$plan = AMember::billingPlans()->get(7);
$categories = AMember::productCategories()->get();
```

По умолчанию возвращается Laravel Collection с полями `status` и `data`. При `AMEMBER_TYPE_RESPONSE=array` используйте `$result['data']`; при `json` возвращается `Illuminate\Http\JsonResponse`.

## Подсказки

- `paginate(50, 0)` — первая страница; размер страницы от 1 до 1000.
- `where('name_l', 'Sm%')` — фильтрация с шаблоном; разные поля объединяются через AND.
- `where()` заменяет условие для того же поля, а повторный `filter()` сохраняет прежнее значение.
- `nested(['billing-plans'])` добавляет связанные записи при чтении. Для создания передавайте массив `nested` без подчёркивания в данных запроса.
- `parameters(['custom_field' => 'value'])` передаёт дополнительные поля, поддерживаемые вашей установкой.
- `format('xml')` и `format('serialize')` возвращают исходную строку в `data`; JSON декодируется.
- Check Access всегда использует JSON. `restorePassword()` отправляет письмо восстановления пароля.
- Старые сервисы фасада могут сохранять фильтры между вызовами. Для независимого запроса используйте новый объект сервиса; прямые разделы вроде `userNotes()` создают новый объект.
- HTTP-ошибки доступны в `status`; ошибки соединения вызывают `ConnectionException`.
- Чтение платежа или возврата не выполняет списание или возврат денег.

## Тесты

В исходном репозитории:

```shell
composer install
composer test
composer test:unit
```

Первый `composer install` разрешает зависимости и создаёт локальный lock-файл; библиотека не хранит его в Git. Тесты используют подмену HTTP и не требуют работающего aMember. Матрица CI настроена для Laravel 10, 11 и 12; фактический результат смотрите в GitHub Actions.

Ошибки и предложения: [GitHub Issues](https://github.com/plutuss/amember-pro-laravel/issues). Лицензия: [MIT](../LICENSE.md).

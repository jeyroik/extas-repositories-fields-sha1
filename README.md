![tests](https://github.com/jeyroik/extas-repositories-fields-sha1/workflows/PHP%20Composer/badge.svg?branch=master&event=push)
![codecov.io](https://codecov.io/gh/jeyroik/extas-repositories-fields-sha1/coverage.svg?branch=master)

# Описание

Адаптор для полей, позволяет автоматически шифровать значение с помощью `sha1`.

Данный адаптор разумно использовать для данных, которые поставляются вместе с пакетом и при установке должны зашироваться.

# Использование

1. Подключаем плагин + указываем маркер

В `extas.json`:

```json
{
    "plugins": [
        {
            "class": "extas\\components\\plugins\\repositories\\PluginFieldSha1",
            "stage": "extas.<entity>.create.before"
        }
    ],
    "my": [
        {
            "name": "test",
            "value": "@sha1(admin)"
        }
    ]
}
```

2. Проверяем

```php
$item = $myRepo->one(['name' => 'test']);

echo $item->getValue(); // d033e22ae348aeb5660fc2140aec35850c4da997
```
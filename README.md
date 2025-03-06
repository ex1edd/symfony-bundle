# SymfonyBundle

`SymfonyBundle` — это Symfony бандл, предоставляющий кастомный нормализатор для работы с объектами

## Требования

- PHP >= 8.0
- Symfony FrameworkBundle 5.4 или выше
- Symfony Serializer 5.4 или выше

## Установка

### Установите бандл с помощью Composer

В вашем проекте Symfony выполните следующую команду для установки бандла:

```bash
composer require prbundle/symfony-bundle
```

## Активация

Для Symfony 4 и выше бандл будет автоматически активирован после установки через Composer. Вам не нужно ничего дополнительно настраивать.

Если вы используете Symfony 3 или ниже, вам необходимо вручную зарегистрировать бандл в файле `config/bundles.php`:

```php
// config/bundles.php

return [
    // другие бандлы
    PrBundle\SymfonyBundle\PrSymfonyBundle::class => ['all' => true],
];
```

## Настройка

Вы можете настроить сервисы и нормализаторы через конфигурационный файл `services.yaml`.

Пример настройки нормализатора:

```yaml
# config/services.yaml

services:
    PrBundle\SymfonyBundle\Serializer\Normalizer\Normalizer:
        tags:
            - { name: 'serializer.normalizer' }
```

Нормализатор автоматически будет обрабатывать даты и другие типы данных в объекте, в зависимости от настроек. Вы можете добавить дополнительные параметры, если это необходимо::
```yaml

# config/services.yaml

parameters:
    pr_bundle.some_parameter: 'value'
```

## Структура проекта

```
/src
    /DependencyInjection
        BundleExtension.php
    /Resources
        /config
            services.yaml
    /Serializer
	/Normalizer
	    Normalizer.php
    SymfonyBundle.php
/composer.json
```
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

После того как вы выполнили команду composer require, composer автоматически загрузит и установит все необходимые зависимости, включая бандл.

## Подключение бандла в Symfony

Для Symfony 4 и выше бандл будет автоматически активирован после установки через Composer. Вам не нужно ничего дополнительно настраивать.

Если вы используете Symfony 3 или ниже, вам необходимо вручную зарегистрировать бандл в файле `config/bundles.php`:

```php
// config/bundles.php

return [
    // другие бандлы
    PrBundle\SymfonyBundle\PrSymfonyBundle::class => ['all' => true],
];
```

### Для старых версий Symfony

Вам может понадобиться вручную зарегистрировать бандл в app/AppKernel.php (вместо config/bundles.php):

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // другие бандлы
        new PrBundle\SymfonyBundle\PrSymfonyBundle(),
    ];

    return $bundles;
}
```

## Использование бандла

Пример использования

```
use App\Serializer\Normalizer\Normalizer;

$normalizer = new Normalizer();

// Пример использования normalize
$normalizedData = $normalizer->normalize($object);
```

## Структура проекта
Файловая структура выглядит следующим образом:
```
/src
    /DependencyInjection
        BundleExtension.php - файл для регистрации зависимостей
    /Resources
        /config
            services.yaml - регистрация сервисов
    /Serializer
	/Normalizer
	    Normalizer.php - нормалайзер, необходимый в проекте
    SymfonyBundle.php - главный файл бандла
/composer.json
```

После того как вы установите бандл с помощью Composer, он будет находиться в папке vendor/prbundle/symfonybundle/

```
/some-project
    /bin
    /config
    ...
    /vendor
        prbundle/symfonybundle/ - папка с бандлом
```



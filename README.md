# SymfonyBundle

`SymfonyBundle` — это Symfony бандл, предоставляющий кастомный нормализатор для работы с объектами

## Процесс разработки

Ниже будут описаны все этапы разработки пакета

### 1. Создание директории

```bash
mkdir symfony-bundle
cd symfony-bundle
```

### 2. Инициализация composer

```bash
composer init
```

На этом этапе задаем данные нашего пакета: name; description; author; minimum stability (допустимые версии, используемые при разработке); package type (мы выбираем symfony-bundle, чтобы symfony автоматически подключался к нашему пакету); license.

### 3. Создание файловой структуры

```bash
mkdir -p src/DependencyInjection src/Serializer/Normalizer src/Resources/config
```

Создаются папки DependencyInjection (для конфигурации бандла и регистрации сервисов); Normalizer (папка, в которой содержится сам нормализатор); config (в ней будет находиться services.yaml, в котором содержится настройка сервисов, параметров и маршрутов).

### 4. Создание основного класса бандла

Создаем файл с классом

```bash
touch src/SymfonyBundle.php
```

Создаем внутри него сам класс

```
<?php

namespace PrBundle\SymfonyBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use PrBundle\SymfonyBundle\DependencyInjection\MyBundleExtension;

class PrSymfonyBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MyBundleExtension();
    }
}
```

### 5. Создание файла расширений

Этот файл будет нужен для конфигурации бандла и регистрации сервисов

```bash
touch src/DependencyInjection/PrBundleExtension.php
```

Содержание самого файла: 

```
<?php

namespace PrBundle\SymfonyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MyBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
```

Он загружает services.yaml из Resources/config и регистрирует сервисы в контейнере Symfony.

### 6. Создание конфигурационного файла сервисов

Теперь создаем этот файл services.yaml: 

```bash
touch src/Resources/config/services.yaml
```

Файл предназначен для регистрации нормалайзера как сервиса и добавления его в serializer Symfony

```
services:
    PrBundle\SymfonyBundle\Serializer\Normalizer\Normalizer:
        tags: ['serializer.normalizer']
```

Таким образом нормализатор интегрируется в общую систему Symfony Serializer и будет использоваться вместе с остальными как один контейнер.

### 7. Добавление нормализатора

Теперь создаем файл с нормализатором, который будет использоваться в проекте

Создаем файл Normalizer.php

```bash
touch src/Serializer/Normalizer/Normalizer.php
```

В нем будет содержаться код кастомного нормалайзера.

### 8. Создание репозитория на GitHub

Далее, для публикации пакета, необходимо загрузить его на GitHub

```bash
git init - создание локального репозитория Git в текущей директории
git add . - подготовка всех файлов текущей директории к коммиту
git commit -m "Initial commit" - создание первого коммита
git remote add origin https://github.com/ex1edd/symfony-bundle.git - подключение удаленного репозитория
git push -u origin main - отправка закоммиченных файлов в репозиторий GitHub
```

### 9. Публикация на Packagist

Теперь переходим на packagist.org и публикуем репозиторий с GitHub

После этого бандл будет готов к установке через Composer.

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



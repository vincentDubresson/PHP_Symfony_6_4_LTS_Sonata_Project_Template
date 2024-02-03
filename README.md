# sonata-project

## Installation Symfony 6.4 LTS

1. Installation de la version skeleton de Symfony 6.4 LTS.

Doc : [Installing & Setting up the Symfony Framework](https://symfony.com/doc/6.4/setup.html)

```shell
symfony new webroot --version="6.4.*"
```

2. Création du `.env.local` depuis une copie du `.env`.

## Installation de la Debug Toolbar

Doc : [Profiler](https://symfony.com/doc/6.4/profiler.html)

1. Installation des bundles.

```shell
composer require --dev symfony/profiler-pack
```

2. Ajout d'une variable d'environnement dans les fichiers `.env` et `.env.local`

```php
APP_DEBUG=<TRUE or FALSE>
```

3. Vidage du cache

```shell
php bin/console cache:clear
```
# sonata-project

## Installation Symfony 6.4 LTS

1. Installation de la version skeleton de Symfony 6.4 LTS.

Doc : [Symfony - Installing & Setting up the Symfony Framework](https://symfony.com/doc/6.4/setup.html)

```shell
symfony new webroot --version="6.4.*"
```

2. Création du `.env.local` depuis une copie du `.env`.

## Installation de la Debug Toolbar

Doc : [Symfony - Profiler](https://symfony.com/doc/6.4/profiler.html)

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

## Installation de Monolog

1. Installation des bundles

Doc : [Symfony - Logging](https://symfony.com/doc/6.4/logging.html#monolog)

2. Configuration type (`config/packages/monolog.yaml`)

Doc : [Blog - Config Monolog](https://www.nicolas-petitjean.com/tirer-partie-du-logger-symfony/)

```yaml
monolog:
    channels:
        - deprecation # Deprecations are logged in the dedicated "deprecation" channel when it exists

when@dev:
    monolog:
        handlers:
            main:
                type: fingers_crossed #Ici, on ne log pas de debug à warning
                action_level: warning
                handler: nested
            nested:
                type: rotating_file #On génère un fichier par jour pour les logs > warning
                path: "%kernel.logs_dir%/%kernel.environment%/%kernel.environment%.log"
                level: warning
                max_files: 10
                channels: [ "!event" ]
            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine", "!console" ]
            deprecation:
                type: rotating_file #On génère un fichier par jour pour les dépréciations.
                channels: [ deprecation ]
                path: "%kernel.logs_dir%/%kernel.environment%/deprecations/%kernel.environment%.log"
                level: debug
                max_files: 10
                formatter: monolog.formatter.json

when@test:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                channels: ["!event"]
                buffer_size: 50 # How many messages should be saved? Prevent memory leaks
            nested:
                type: rotating_file
                path: "%kernel.logs_dir%/%kernel.environment%/%kernel.environment%.log"
                level: info
                max_files: 30
                formatter: monolog.formatter.json

when@prod:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                buffer_size: 50 # How many messages should be saved? Prevent memory leaks
            nested:
                type: rotating_file
                path: "%kernel.logs_dir%/%kernel.environment%/%kernel.environment%.log"
                level: debug
                max_files: 30
                formatter: monolog.formatter.json

            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine"]

            deprecation:
                type: rotating_file
                channels: [deprecation]
                path: php://stderr
                level: debug
                max_files: 30
                formatter: monolog.formatter.json
```

## Installation de Twig

1. Installation des bundles

Doc : [Symfony - Rendering a template](https://symfony.com/doc/6.4/page_creation.html#rendering-a-template)

```shell
composer require twig
```

2. Prévoir une première utilisation de Chrome Lighthouse pour la mise en place des premières bonnes pratiques
concernant le SEO (ex: balises meta). Privilégier `APP_ENV=prod` pour éviter les problèmes qui concerne la toolbar.

Exemple (`base.html.twig`) :

```html
<!DOCTYPE html>
<html lang="fr"> --> IMPORTANT
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" /> --> IMPORTANT
        <meta name="description" content="Mini projet Sonata."> --> IMPORTANT
        <title>{% block title %}Welcome!{% endblock %}</title>
[...]
```


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

  handlers:
    main:
      type: fingers_crossed
      action_level: error
      handler: nested
      excluded_http_codes: [403, 404, 405]
      buffer_size: 50 # How many messages should be saved? Prevent memory leaks
    nested:
      type: rotating_file
      path: "%kernel.logs_dir%/%kernel.environment%/%kernel.environment%.log"
      level: error
      max_files: 30
      channels: [ "!event" ]
    #        mailed:
    #            type: symfony_mailer
    #            from_email: '%noreply_email%'
    #            to_email: '%developer_email%'
    #            level: error
    #            subject: Erreur critique
    #            formatter: monolog.formatter.html
    #            content_type: text/html
    console:
      type: console
      process_psr_3_messages: false
      channels: [ "!event", "!doctrine" ]
```

La partie mailed sera à décommenter lors de l'installation de mailer/symfony.

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

## Installation de Nelmio Security

1. Installation du bundle

Doc : [Symfony - NelmioSecurityBundle](https://symfony.com/bundles/NelmioSecurityBundle/current/index.html#installation)

```shell
composer require nelmio/security-bundle
```

2. Configuration type (`config/packages/nelmio_security.yaml`)

Après avoir installé le webpack encore, penser à modifier le favicon.ico.

```yaml
# config/packages/nelmio_security.yaml
nelmio_security:
  # prevents framing of the entire site
  clickjacking:
    paths:
      '^/.*': DENY

  # prevents redirections outside the website's domain
  external_redirects:
    abort: true
    log: true

  # prevents inline scripts, unsafe eval, external scripts/images/styles/frames, etc
  csp:
    hosts: []
    content_types: []
    enforce:
      level1_fallback: false
      browser_adaptive:
        enabled: false
      # CSP headers in alphabetical order.
      base-uri:
        - 'self'
      block-all-mixed-content: true # defaults to false, blocks HTTP content over HTTPS transport
      connect-src:
        - 'self'
      default-src:
        - 'none'
      font-src:
        - 'self'
      form-action:
        - 'self'
      frame-ancestors:
        - 'none'
      img-src:
        - 'self'
      object-src:
        - 'none'
      script-src:
        - 'self'
      style-src:
        - 'self'
        - 'unsafe-inline'
      upgrade-insecure-requests: true # defaults to false, upgrades HTTP requests to HTTPS transport

  # disables content type sniffing for script resources
  content_type:
    nosniff: true

  # forces Microsoft's XSS-Protection with
  # its block mode
  xss_protection:
    enabled: true
    mode_block: true

  # Send a full URL in the ``Referer`` header when performing a same-origin request,
  # only send the origin of the document to secure destination (HTTPS->HTTPS),
  # and send no header to a less secure destination (HTTPS->HTTP).
  # If ``strict-origin-when-cross-origin`` is not supported, use ``no-referrer`` policy,
  # no referrer information is sent along with requests.
  referrer_policy:
    enabled: true
    policies:
      - 'strict-origin-when-cross-origin'

  # forces HTTPS handling, don't combine with flexible mode
  # and make sure you have SSL working on your site before enabling this
  #    forced_ssl:
  #        hsts_max_age: 2592000 # 30 days
  #        hsts_subdomains: true
  #        redirect_status_code: 302 # default, switch to 301 for permanent redirects

  # flexible HTTPS handling, read the detailed config info
  # and make sure you have SSL working on your site before enabling this
#    flexible_ssl:
#        cookie_name: auth
#        unsecured_logout: false
```

## Installation de PHPSTAN

1. Installation du bundle d'origine

Doc : [PHPSTAN - Getting Started](https://phpstan.org/user-guide/getting-started)

```shell
composer require --dev phpstan/phpstan
```

2. Installation du bundle Extensions Installer

Doc : [GitHub - PHPSTAN Extensions Installer](https://github.com/phpstan/extension-installer)

```shell
composer require --dev phpstan/extension-installer
```

3.Installation du bundle Symfony

Doc : [GitHub - PHPSTAN Symfony](https://github.com/phpstan/phpstan-symfony)

```shell
composer require --dev phpstan/phpstan-symfony
```

4. Installation du bundle Doctrine

Doc : [GitHub - PHPSTAN Doctrine](https://github.com/phpstan/phpstan-doctrine)

```shell
composer require --dev phpstan/phpstan-doctrine
```

5. Configuration de PHPSTAN

Cette config n'est pas définitive. Il est possible de rajouter des exclusions.

```yaml
parameters:
    level: 8
    tmpDir: '%rootDir%/../../../tmp/phpstan'
    symfony:
        # @see https://github.com/phpstan/phpstan-symfony#configuration
        containerXmlPath: '%rootDir%/../../../var/cache/test/App_KernelTestDebugContainer.xml'
        consoleApplicationLoader: 'tests/phpstan/console_application.php'
    excludePaths:
        - '%rootDir%/../../../src/Controller/TestController.php'
    doctrine:
        objectManagerLoader: '%rootDir%/../../../tests/phpstan/object_manager.php'
```

## Installation de PHP Cs Fixer

1. Installation du bundle

Doc : [Site officiel](https://cs.symfony.com/)

```shell
composer require --dev friendsofphp/php-cs-fixer
```

2. Configuration de PHP Cs Fixer

Doc : [Mlocati](https://mlocati.github.io/php-cs-fixer-configurator/#version:3.49)

```php
<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->append([
        __FILE__,
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        // @see https://mlocati.github.io/php-cs-fixer-configurator/
        '@PhpCsFixer' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => true,
        'concat_space' => ['spacing' => 'one'],
        'combine_consecutive_issets' => false,
        'combine_consecutive_unsets' => false,
        'doctrine_annotation_spaces' => ['before_array_assignments_colon' => false, 'before_array_assignments_equals' => false, 'after_array_assignments_equals' => false],
        'explicit_indirect_variable' => false,
        'explicit_string_variable' => false,
        'increment_style' => false,
        'linebreak_after_opening_tag' => true,
        'method_chaining_indentation' => false,
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'native_function_casing' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset' => true,
        'no_superfluous_elseif' => false,
        'no_useless_else' => true,
        'no_whitespace_before_comma_in_array' => true,
        'ordered_imports' => true,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_to_comment' => ['ignored_tags' => ['var']],
        'php_unit_test_class_requires_covers' => false,
        'single_blank_line_before_namespace' => true,
        'single_quote' => true,
        'space_after_semicolon' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
```

## Installation de TwigCs

1. Installation du bundle

Doc : [GitHub - TwigCS](https://github.com/friendsoftwig/twigcs)

```shell
composer require --dev friendsoftwig/twigcs
```

## Installation de var-dumper

1. Installation du bundle

Doc : [Symfony - VarDumper](https://symfony.com/doc/6.4/components/var_dumper.html)

```shell
composer require --dev symfony/var-dumper
```

2. Installation du debug bundle

```shell
composer require --dev symfony/debug-bundle
```

3. Configuration de var-dumper

Créer un fichier `config/packages/debug.yaml`

```yaml
when@dev:
  debug:
    # Forwards VarDumper Data clones to a centralized server allowing to inspect dumps on CLI or in your browser.
    # See the "server:dump" command to start a new server.
    dump_destination: "tcp://%env(VAR_DUMPER_SERVER)%"
```
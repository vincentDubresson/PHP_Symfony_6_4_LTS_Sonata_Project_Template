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

3. Installation du bundle Twig inline Css

Doc : [Twig - Inline CSS](https://twig.symfony.com/doc/3.x/filters/inline_css.html)

```shell
composer require twig/cssinliner-extra
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

## Installation de Docrtrine

1. Installation des bundles

[Symfony - Installing Doctrine](https://symfony.com/doc/6.4/doctrine.html#installing-doctrine)

```shell
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

2. Configuration basique (`config/packages/doctrine.yaml`)

```yaml
doctrine:
    dbal:
        url: '%env(resolve:DATABASE_URL)%'

        # IMPORTANT: You MUST configure your server version,
        # either here or in the DATABASE_URL env var (see .env file)
        #server_version: '16'

        profiling_collect_backtrace: '%kernel.debug%'
    orm:
        auto_generate_proxy_classes: true
        naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
        auto_mapping: true
        mappings:
            App:
                type: attribute
                is_bundle: false
                dir: '%kernel.project_dir%/src/Entity'
                prefix: 'App\Entity'
                alias: App
        hydrators:
            # Used to hydrate results as a non-associative scalar array.
            App\Doctrine\Hydrator\ColumnHydrator: App\Doctrine\Hydrator\ColumnHydrator

when@test:
    doctrine:
        dbal:
            # "TEST_TOKEN" is typically set by ParaTest
            dbname_suffix: '_test%env(default::TEST_TOKEN)%'

when@prod:
    doctrine:
        orm:
            auto_generate_proxy_classes: false
            proxy_dir: '%kernel.build_dir%/doctrine/orm/Proxies'
            query_cache_driver:
                type: pool
                pool: doctrine.system_cache_pool
            result_cache_driver:
                type: pool
                pool: doctrine.result_cache_pool

    framework:
        cache:
            pools:
                doctrine.result_cache_pool:
                    adapter: cache.app
                doctrine.system_cache_pool:
                    adapter: cache.system
```

3. Installation de Doctrine Behaviors

Doc : [GitHub - Doctrine Behaviors](https://github.com/KnpLabs/DoctrineBehaviors)

```shell
composer require knplabs/doctrine-behaviors
```

4. Installation de Symfony Validator

Doc : [GitHub - Validation](https://symfony.com/doc/6.4/validation.html)

```shell
composer require symfony/validator
```

## Installation du bundle Apache Pack

```shell
composer require symfony/apache-pack
```

## Installation du bundle Security

1. Installation du Bundle

Doc : [Symfony - Security](https://symfony.com/doc/6.4/security.html)

```shell
composer require symfony/security-bundle
```

2. Création d'une entité user

Attention : Si une erreur de Type Dbal se présente, ajouter la ligne ci-dessous
dans le `composer.json`

```shell
"doctrine/dbal": "^3.8",
```

Source : [StackOverFlow](https://stackoverflow.com/questions/77939886/doctrine-undefined-constant-doctrine-dbal-types-typesarray)

3. Installation du bundle rate-limiter

Doc : [Symfony - Rate Limiter](https://symfony.com/doc/6.4/rate_limiter.html)

```shell
composer require symfony/rate-limiter
```

4. Création du Login Form

```shell
php bin/console make:security:form-login
```

5. Mise en place du remember me

Doc : [Symfony - Remember me](https://symfony.com/doc/current/security/remember_me.html#security-remember-me-authenticator)

6. Exemple de config

```yaml
# security.yaml
security:
    # https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
    # https://symfony.com/doc/current/security.html#loading-the-user-the-user-provider
    providers:
        # used to reload user from session & other features (e.g. switch_user)
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
            form_login:
                login_path: app_security_login
                check_path: app_security_login
                enable_csrf: true
                default_target_path: app_logged_action
            logout:
                path: app_security_logout
                # where to redirect after logout
                target: app_security_login
            login_throttling: true
            remember_me:
                secret: '%kernel.secret%' # required
                lifetime: 604800 # 1 week in seconds

            # activate different ways to authenticate
            # https://symfony.com/doc/current/security.html#the-firewall

            # https://symfony.com/doc/current/security/impersonating_user.html
            # switch_user: true

    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        # - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/logged, roles: ROLE_USER }

    access_decision_manager:
        strategy: unanimous

when@test:
    security:
        password_hashers:
            # By default, password hashers are resource intensive and take time. This is
            # important to generate secure password hashes. In tests however, secure hashes
            # are not important, waste resources and increase test times. The following
            # reduces the work factor to the lowest possible values.
            Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface:
                algorithm: auto
                cost: 4 # Lowest possible value for bcrypt
                time_cost: 3 # Lowest possible value for argon
                memory_cost: 10 # Lowest possible value for argon
```

```yaml
#framework.yaml
# Remove or comment this section to explicitly disable session support.
session:
  handler_id: null
  cookie_secure: auto
  cookie_samesite: lax
  cookie_lifetime: 129600   # 36 heures en secondes (36 * 60 * 60)
```

## Installation de Mailer Symfony

1. Installation du bundle

Doc : [Symfony - Mailer](https://symfony.com/doc/6.4/mailer.html)

```shell
composer require symfony/mailer
```

## Installation du bundle Reset Password

1. Installation du bundle

Doc : [Symfony - Reset Password](https://symfony.com/doc/6.4/security/passwords.html#reset-password)

```shell
composer require symfonycasts/reset-password-bundle
```

2. Installation de symfony Form

```shell
composer require symfony/form
```

## Installation du Webpack Encore

1. Installation du bundle

Doc : [Symfony - Webpack Encore](https://symfony.com/doc/6.4/frontend/encore/installation.html)

Créer un fichier `.nvmrc` comprenant la ligne `18.18.2`

```shell
composer require symfony/webpack-encore-bundle
nvm use && npm install
```

2. (Optionnel) Installer React

```shell
nvm use && npm install @babel/preset-react@^7.0.0 --save-dev
```

3. (Optionnel) Installer Sass Loader

```shell
nvm use && npm install sass-loader@^14.0.0 sass --save-dev
```

4. (Optionnel) Installer Typescript

```shell
nvm use && npm install typescript ts-loader@^9.0.0 --save-dev
```

5. Configuration de base de webpack Encore

```js
const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
// directory where compiled assets will be stored
.setOutputPath('public/build/')
// public path used by the web server to access the output path
.setPublicPath('/build')
// only needed for CDN's or subdirectory deploy
//.setManifestKeyPrefix('build/')

/*
 * ENTRY CONFIG
 *
 * Each entry will result in one JavaScript file (e.g. app.js)
 * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
 */
.addEntry('app', './assets/app.js')

// When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
.splitEntryChunks()

// will require an extra script tag for runtime.js
// but, you probably want this, unless you're building a single-page app
.enableSingleRuntimeChunk()

/*
 * FEATURE CONFIG
 *
 * Enable & configure other features below. For a full
 * list of features, see:
 * https://symfony.com/doc/current/frontend.html#adding-more-features
 */
.cleanupOutputBeforeBuild()
.enableBuildNotifications()
.enableSourceMaps(!Encore.isProduction())
// enables hashed filenames (e.g. app.abc123.css)
.enableVersioning(Encore.isProduction())

// configure Babel
// .configureBabel((config) => {
//     config.plugins.push('@babel/a-babel-plugin');
// })

// enables and configure @babel/preset-env polyfills
.configureBabelPresetEnv((config) => {
config.useBuiltIns = 'usage';
config.corejs = '3.23';
})

// enables Sass/SCSS support
.enableSassLoader()

// enable Tailwind
.enablePostCssLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
```

5. Installation et configuration de Tailwind

Doc : [Tailwind - Tailwind avec Symfony](https://tailwindcss.com/docs/guides/symfony)

6. Création d'une page avec un composant React

Doc : [Blog YoanDev](https://yoandev.co/du-react-avec-symfony)

## Installation de ESLint

1. Installation du bundle

Doc : [Eslint](https://eslint.org/docs/latest/use/getting-started)

```shell
npm init @eslint/config
```

Suivre les consignes, puis choisir Airbnb.

2. Configuration

Fichier `.eslintrc.json` :

```json
{
    "parser": "@babel/eslint-parser",
    "env": {
        "browser": true,
        "es2021": true
    },
    "extends": "airbnb-base",
    "parserOptions": {
        "requireConfigFile": false,
        "ecmaVersion": "latest",
        "sourceType": "module",
        "babelOptions": {
            "presets": ["@babel/preset-react"]
        }
    },
    "rules": {
        "import/no-extraneous-dependencies": 0,
        "no-unused-vars": 0
    }
}
```

Vous aurez sûrement besoin d'installer d'autres packages :
- "file-loader": "^6.2.0"
- "@babel/eslint-parser": "^7.23.10"

## Installation de Ice Vich Uploader Bundle

1. Installation du bundle

Ajouter ces lignes dans le `composer.json`

```
        "ice/vich-uploader-bundle": "7.2.0",
```

```
    "repositories": [
        {
            "type": "composer",
            "url": "https://satis.ice-dev.com:446/"
        }
    ]
```

Puis faire un `composer update`.

2. Configuration standard

```yaml
# config/packages/vich_uploader.yaml
vich_uploader:
  db_driver: orm

parameters:
  convert_images_webp_on_upload: true

  #mappings:
  #    products:
  #        uri_prefix: /images/products
  #        upload_destination: '%kernel.project_dir%/public/images/products'
  #        namer: Vich\UploaderBundle\Naming\SmartUniqueNamer
```

```yaml
# config/packages/liip_imagine.yaml
# Documentation on how to configure the bundle can be found at: https://symfony.com/doc/current/bundles/LiipImagineBundle/basic-usage.html
liip_imagine:
  # valid drivers options include "gd" or "gmagick" or "imagick"
  driver: "gd"
  twig:
    mode: lazy
```

```yaml
# config/routes/liip_imagine.yaml
_liip_imagine:
  resource: "@LiipImagineBundle/Resources/config/routing.yaml"
```

```yaml
# config/packages/twig.yaml
twig:
  default_path: '%kernel.project_dir%/templates'
  paths:
    'assets/images': images
  form_themes:
    - '@IceVichUploader/Form/fields.html.twig'

when@test:
  twig:
    strict_variables: true
```

```yaml
# config/services.yaml
imports:
    - { resource: '../vendor/ice/vich-uploader-bundle/Resources/config/config.yml' }

```
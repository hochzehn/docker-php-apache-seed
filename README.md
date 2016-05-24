# docker-php-apache-seed

Start a fresh PHP CLI project with Docker - no install on your local machine.

## What is this about?

Create a fresh CLI job with PHP to run cron jobs or other tasks in a predictable, enclosed environment. This makes deployment so easy: You only need Docker Engine and Bash on the target machine, and everything else is contained in here.

## How to use

1. Fork or clone this repository.
2. Copy `config/settings.sample.yml` to `config/settings.yml` (e.g. by using `cp config/settings.sample.yml config/settings.yml`)
3. Run `bin/run.sh YOUR_NAME` to see the script in action.

You should see something like this:

    $ bin/run.sh Foo Bar
    Di 24. Mai 11:11:45 CEST 2016
    Starting.
    
    Di 24. Mai 11:11:45 CEST 2016
    Installing dependencies. This may take a while on the first run.
    
    Di 24. Mai 11:11:46 CEST 2016
    Building docker image. This may take a while on the first run.
    
    Di 24. Mai 11:11:46 CEST 2016
    Running job.
    Hello, YOUR_NAME!
    
    Di 24. Mai 11:11:46 CEST 2016
    Claiming ownership of all files.
        
    Di 24. Mai 11:11:47 CEST 2016
    Script finished.

## Recommended: Update PHP version

The PHP version is locked to a specific minor version in `docker/php-cli/Dockerfile`, currently `7.0.6-alpine`. We do this to have a fully predictable environment when deploying to a different machine, like to production.

However we will probably lag behind the official releases, so this repository may not be up to date with the latest fixes and releases. So before starting with your own coding, you might want to set the current release as your working version.

To do so, update the first line in `docker/php-cli/Dockerfile` to the latest available version with `-alpine` suffix as [listed here](https://hub.docker.com/_/php/), e.g. `FROM php:7.0.6-alpine`.

## Your own code

Start coding away in `src/Application.php` and create more classes in `src` and sub-directories as you see fit. The root namespace is named `Application\`, you may want to change it to reflect your purpose better. To do so, edit `autoload: psr-4` section in `composer.json` as well as `src/Application.php` and `src/Configuration.php`.

## Tests

Tests are supported via [PHPUnit](https://phpunit.de/). Test cases should go into `test/`. Run all tests with `bin/test.sh`. Parameters given will be passed to PHPUnit directly, e.g. `bin/test.sh --version`.

Testing output is also stored in `var/test.log` for easier readability. Code coverage reports are generated in `var/coverage`. 

## Simple configuration

This seed repository includes a simple mechanism to keep configuration out of the code. In `config/settings.yml`, store all your application's settings which might be changed on a production machine.

To access configuration from code, a very simple wrapper class is included: `Application/Configuration`. You can access configuration values by using the static (yikes!) call to `Application\Configuration::get('cron/batch/size')`, which will return `42` for this configuration.:

    # config/settings.yml
    cron:
      batch:
        size: 42
        
Boolean values are also supported, so `dragons_be_here: true` will actually be converted to a boolean value, thanks to the awesome underlying [Yaml Component](https://github.com/symfony/yaml) from [Symfony](https://github.com/symfony/symfony).

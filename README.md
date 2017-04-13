laravel-bootstrap-adminlte-starter-kit 
=============
[![build status](https://gitlab.com/oprudkyi/laravel-bootstrap-adminlte-starter-kit/badges/master/build.svg)](https://gitlab.com/oprudkyi/laravel-bootstrap-adminlte-starter-kit/commits/master)


Template for websites with basic functionality. It is based on next ideas:

- have common features already integrated and configured (tests,laravel-mix/webpack/babel,bower etc)
- simplify updates (via git merge from this project)
- extensive use of .env config (slightly more then original Laravel) 
- 'make' based macro-tool for often used commands 
- [GitLab CI integration](https://gitlab.com/help/ci/README.md)


Last Modified: 2017-04-12


License
=======

Copyright (c) 2016-2017 Oleksii Prudkyi

The laravel-bootstrap-adminlte-starter-kit kit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).


Introduction
============

Just base functionality for other projects

Project includes already preconfigured resources:

- [Laravel 5.4](http://laravel.com/)  
- [AdminLte template](https://almsaeedstudio.com/) [Laravel Integration](https://github.com/acacha/adminlte-laravel) 
- [jrean/laravel-user-verification](https://github.com/jrean/laravel-user-verification)
- [oprudkyi/laravel-mail-logger](https://github.com/oprudkyi/laravel-mail-logger)
- Front-End:
	- [Bower](https://bower.io/)
	- [Bootstrap](http://getbootstrap.com/)
	- [Font Awesome](http://fontawesome.io/)
	- [jQuery](https://jquery.com/)
	- [DataTables](https://datatables.net/)
	- [Moment.js](http://momentjs.com/)
	- [Bootstrap 3 Date/Time Picker](https://github.com/Eonasdan/bootstrap-datetimepicker)
	- [js-error-alert](https://github.com/oprudkyi/js-error-alert)

- Testing (preconfigured for unit,functional and acceptance tests):
	- [Codeception](http://codeception.com/) - BDD-styled PHP testing framework atop of [PHPUnit](https://phpunit.de/)
	- [Codeception/PhpBuiltinServer](https://github.com/tiger-seo/PhpBuiltinServer) - Codeception extension to start and stop PHP built-in web server for your tests.
	- [Phantoman](https://github.com/grantlucas/phantoman) - The Codeception extension for automatically starting and stopping PhantomJS when running tests.
	- [codeception-events-scripting](https://github.com/oprudkyi/codeception-events-scripting) - The Codeception extension for automatically running shell scripts on Codeception events.
	- [MailCatcher](https://mailcatcher.me/) - catches mails and provides API for testing
	- [Codeception MailCatcher Module](https://github.com/captbaritone/codeception-mailcatcher-module)
	- [PhantomJS](http://phantomjs.org/) - a headless WebKit, used for acceptance testing
	- [Setup Test DB Command for Laravel](https://github.com/SocialEngine/setup-test-db)


Creation of new site based on starter kit
============

```sh
#clone original repository
git clone git@gitlab.com:oprudkyi/laravel-bootstrap-adminlte-starter-kit.git my_project

#cd to project
cd my_project

#delete origin
git remote rm origin

#use your new repository as main source 
git remote add origin git@gitlab.com:oprudkyi/web-site.git

#keep original source for updates
git remote add starter-kit git@gitlab.com:oprudkyi/laravel-bootstrap-adminlte-starter-kit.git

#push to your repository
git push -u origin master
```

Keeping your site in sync with starter kit
============

```sh
git fetch starter-kit
git merge starter-kit/master
git push
```

or 
```sh
make merge-starterkit
git push
```


Installation
============

If you are building from the first time out of the source repository, you will
need to generate the configure scripts. From the top directory, do:

    ./bootstrap.sh

Once the configure scripts are generated, 'make' system can be configured.
From the top directory, do:

    ./configure


Run ./configure --help to see other configuration options

Install configured dependencies - tools like composer/bower and components as defined in composer.json, bower.json, package.json :

	make install-dependencies

For automicity and performance of CI the repositories of composer/bower/npm are stored under .install-cache directory (pointed out via rc files)


Testing
=======

There are a large number of tests that can all be run
from the top-level directory.

          make -k check
          make -k check-functional
          make -k check-acceptance

This will make all of the libraries (as necessary), and run through
the unit tests defined in each of the client libraries. If a single
language fails, the make check will continue on and provide a synopsis
at the end.

Testing over GitLab CI
=======

Project has preconfigured [GitLab CI integration](https://gitlab.com/help/ci/README.md), all configs are stored in the [.gitlab-ci.yml](.gitlab-ci.yml) 

There is used special [docker image](https://hub.docker.com/r/oprudkyi/laravel-bootstrap-adminlte-starter-kit) with preinstalled dependencies:  

  - nodejs/npm 
  - ruby/gem 
  - autotools (automake/autoconf) 
  - phnatomjs (headless webbrowser for testing) 
  - git/wget/curl etc


To avoid possible security issues if you are using starter-kit for private projects at GitLab site, please disable GitLab's shared runners and start private one.


Boostraping development environment
===================================

```sh
cp .env.example .env
vim .env

#for sqlite db
touch storage/database/play.sqlite
./artisan migrate

#generate key
./artisan key:generate -v
```

Update dependencies
===================

	make update-dependencies

	or

	make update-dependencies-production

it will search for updated packages for composer/npm/bower and install them as well will update lock/json files 


Mailcatcher integration
======================

Mailcatcher is configured in the .env.example for port 1025, 
tests use different port (11031) so tests can be run while development instance of maicatcher is running 

Run:

	make run-mailcatcher

Stop:

	make stop-mailcatcher

Mailcatcher web gui available via http://127.0.0.1:1080/	


Javascript/Css assets
====================

Intergration is based on [Laravel Mix](https://laravel.com/docs/master/mix) and 
[WebPack](https://webpack.js.org/) as css/js compilation system . 

The building script is webpack.mix.js. System is configured to generate single js file from all packages provided (as well single css file)  

if you add/remove packages, you may also need to edit resources/assets/sass/app.scss and resources/javascripts/app.js for adding/removing css/scss/js 

use 'make mix' or 'make mix-watch' to compile resources

custom css rules you can add to resources/assets/sass/starterkit/starter-kit-customize.scss
it's applied after any other css, so it's possible to change any css behavior here


Manual Deployment Initialization
================================
This isn't adivsed , just for info:

* First, clone your repository to production/staging server 
    
* configure production environment
```sh
	./bootstrap.sh
	./configure --enable-tests=no
	make install-dependencies-production
	chmod 777 -R storage
```

* create db (in case of mysql)
```sh
sudo mysql 
```

```sql
CREATE DATABASE IF NOT EXISTS starterkit_db CHARSET=utf8;
CREATE USER 'starterkit_user'@'%' IDENTIFIED BY 'starterkit_password';
GRANT ALL PRIVILEGES ON starterkit_db.* TO 'starterkit_user'@'%';
```

* create env file
```sh
cp .env.example.production .env
vim .env
```

* create key

```sh
php artisan key:generate
```

* migrate db

```sh
php artisan migrate
```

* optimize app

```sh
make production-optimize
```

it will run next commands:
```sh
#clear cache
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan clear-compiled

#optimize
composer dump-autoload --optimize


#caching 
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan optimize


```
* recompile js/css
```sh
npm run production
```

Manual Deployment
================

There is script ```deploy_production.sh``` with simplified git based deployment, if it is run on server it will autoupdate git and dependencies, there are next commands:
```sh
php artisan down
git pull
make install-dependencies-production
php artisan migrate --force --no-interaction --verbose
make production-optimize
php artisan up
```

Please note, ```deploy_production.sh``` is very optimistic for errors and will break/stop if something wrong (and leave site in maintenance mode), then you have to fix it manually

Deployment via [GitLab CI](https://gitlab.com/help/ci/README.md)
================

[.gitlab-ci.yml](.gitlab-ci.yml) is configured to support simple ssh/git based deployment via GitLab Gui. i.e. there is manual step/job in pipelines - "deploy to production"

To use it you have to add next Secret Variables (in CI/CD Pipelines settings):
 - PRODUCTION_URI  - url to production server
 - PRODUCTION_SSH_PRIVATE_KEY - ssh private key text (~/.ssh/id_rsa) which has access to server (i.e. public key added to ~/.ssh/authorized_keys on server
 - PRODUCTION_DEPLOY_REMOTE_COMMAND - something like :  ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null user_on_server@server_host /path/to/source/on/server/deploy_production.sh


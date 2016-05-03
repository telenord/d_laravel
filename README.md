laravel-bootstrap-adminlte-starter-kit 
=============
template for websites with basic functionality implemented
- Laravel ((http://laravel.com/)  
- AdminLte (https://almsaeedstudio.com/) (https://github.com/acacha/adminlte-laravel) 
- composer
- jrean/laravel-user-verification
- oprudkyi/laravel-mail-logger
- js:
	- bower
	- Bootstrap
	- jQuery 
	- fontawesome
	- datatables

- testing:
	- codeception
	- phpunit
	- mailcatcher
	- codeception/phpbuiltinserver
	- captbaritone/mailcatcher-codeception-module
	- site5/phantomank
	- oprudkyi/codeception-events-scripting



Last Modified: 2016-05-03

License
=======

Copyright (C) 2016 Oleksii Prudkyi

The laravel-bootstrap-adminlte-starter-kit kit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).


Introduction
============

Just base functionality for other projects


Installation
============

If you are building from the first time out of the source repository, you will
need to generate the configure scripts.  (This is not necessary if you
downloaded a tarball.)  From the top directory, do:

    ./bootstrap.sh

Once the configure scripts are generated, Time Spotter can be configured.
From the top directory, do:

    ./configure


Run ./configure --help to see other configuration options

Make :

	make download-dependencies


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


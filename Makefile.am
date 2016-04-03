#testing ----------------------------------------

CODECEPT = ./vendor/bin/codecept
ARTISAN = ./artisan

check-local: check_testing_db_seed check_functional

.PHONY: check_testing_db_seed check_functional check_codecept

check_functional: check_codecept

check_codecept:
	$(CODECEPT) run functional

check_testing_db_seed: 
	$(ARTISAN) db:seed-test --env=testing


#downloads -----------------------------------------

download-dependencies-local: composer_install 

COMPOSER = composer.phar
BOWER = node_modules/.bin/bower
GULP = node_modules/.bin/gulp

composer_install:
	$(PHP) -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
	$(PHP) composer-setup.php
	$(PHP) -r "unlink('composer-setup.php');"
	$(PHP) $(COMPOSER) install
	$(NPM) install
	$(BOWER) install
	$(GULP)

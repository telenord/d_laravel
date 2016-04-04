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


.PHONY: check_testing_db_seed check_acceptance

check-acceptance-local: check_testing_db_seed check_acceptance

check_acceptance: 
	$(CODECEPT) run --env phantom acceptance


#downloads -----------------------------------------

COMPOSER = composer.phar

$(COMPOSER):
	$(PHP) -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
	$(PHP) composer-setup.php
	$(PHP) -r "unlink('composer-setup.php');"
	$(PHP) $(COMPOSER) install

BOWER = node_modules/.bin/bower
GULP = node_modules/.bin/gulp

$(BOWER):
	$(NPM) install

download-dependencies-local: $(COMPOSER) $(BOWER) others_install

.PHONY: others_install

others_install:
	$(BOWER) install
	$(GULP)

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

download-dependencies-local: $(MAILCATCHER) $(COMPOSER) $(BOWER) others_install

.PHONY: others_install

others_install:
	$(BOWER) install
	$(GULP)

#codecept and generated files ------------------

CODECEPT = ./vendor/bin/codecept

$(CODECEPT) : $(COMPOSER)

check_SCRIPTS = tests/_support/_generated/AcceptanceTesterActions.php tests/_support/_generated/FunctionalTesterActions.php tests/_support/_generated/UnitTesterActions.php

$(check_SCRIPTS) : tests/*.yml codeception.yml
	$(CODECEPT) build

CLEANFILES = $(check_SCRIPTS)

#mailcatcher ----------------------------------

MAILCATCHER = vendor/ruby/bin/mailcatcher
MAILCATCHER_RUNNER = GEM_HOME=vendor/ruby $(MAILCATCHER)

$(MAILCATCHER) :
	$(GEM) install mailcatcher --no-format-executable --install-dir vendor/ruby --no-document

mailcatcher_start : $(MAILCATCHER) mailcatcher_stop_pre
	echo "Start mailcatcher"
	$(MAILCATCHER_RUNNER) --ip 127.0.0.1 --smtp-port 11031 --http-port 11091
	

mailcatcher_stop_pre mailcatcher_stop:
	echo "Stop mailcatcher"
	-$(CURL) -v -X DELETE http://127.0.0.1:11091

.PHONY: mailcatcher_start mailcatcher_stop mailcatcher_stop_pre
.NOTPARALLEL: $(MAILCATCHER) mailcatcher_stop_pre

#----------------------------------------------
ARTISAN = ./artisan

#probably TESTS
check-local: $(check_SCRIPTS) check_testing_db_seed check_functional

.PHONY: check_testing_db_seed check_functional check_codecept

check_functional: check_codecept

check_codecept:
	$(CODECEPT) run functional

check_testing_db_seed: 
	$(ARTISAN) db:seed-test --env=testing


#codecept acceptance testing ------------------

.PHONY: check_testing_db_seed check_acceptance check_acceptance_long

check-acceptance-local: $(MAILCATCHER) $(check_SCRIPTS) check_testing_db_seed check_acceptance_long

.NOTPARALLEL: check_acceptance mailcatcher_start mailcatcher_stop

check_acceptance: 
	$(CODECEPT) run --env phantom acceptance

#!!!on error mailcatcher won't stopped
check_acceptance_long: mailcatcher_start check_acceptance mailcatcher_stop 



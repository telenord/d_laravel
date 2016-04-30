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

$(MAILCATCHER) :
	$(GEM) install mailcatcher --no-format-executable --install-dir vendor/ruby --no-document


#----------------------------------------------
ARTISAN = ./artisan

#probably TESTS
check-local: $(check_SCRIPTS) check_functional

.PHONY: check_functional check_codecept

check_functional: check_codecept

check_codecept:
	$(CODECEPT) run functional

#codecept acceptance testing ------------------

.PHONY: check_acceptance 

check-acceptance-local: $(MAILCATCHER) $(check_SCRIPTS) check_acceptance

check_acceptance: 
	$(CODECEPT) run --env phantom acceptance




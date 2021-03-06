#This file is part of laravel-bootstrap-adminlte-starter-kit.

#Copyright (c) 2016 Oleksii Prudkyi

#downloads -----------------------------------------

COMPOSER = composer.phar

$(COMPOSER):
	$(PHP) -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
	$(PHP) composer-setup.php --install-dir="."
	$(PHP) -r "unlink('composer-setup.php');"


BOWER = node_modules/.bin/bower

$(BOWER):
	$(NPM) install

.PHONY: development_composer_packages

#on fresh install artisan fails to work, so run composer twice
development_composer_packages: $(COMPOSER)
	$(PHP) $(COMPOSER) install --no-plugins --no-scripts
	$(PHP) $(COMPOSER) install
	$(NPM) install


.PHONY: development_others_install

development_others_install:
	$(BOWER) install --allow-root
	$(NPM) run dev-quiet

download-dependencies-local: $(MAILCATCHER) development_composer_packages |  development_others_install

install-dependencies-local: download-dependencies-local

.PHONY: production_others_install

production_others_install:
	$(BOWER) install
	$(NPM) run production-quiet

.PHONY: production_composer_packages

production_composer_packages: $(COMPOSER)
	$(PHP) $(COMPOSER) install --no-plugins --no-scripts --no-dev
	$(PHP) $(COMPOSER) install --no-dev

production_node_packages:
	$(NPM) install --only=production

download-dependencies-production-local: production_composer_packages production_node_packages | production_others_install

install-dependencies-production-local: download-dependencies-production-local

.PHONY: rm_composer update_deps update_deps_production

rm_composer: 
	$(RM) -r composer.phar

update_deps:
	$(PHP) $(COMPOSER) update --no-plugins --no-scripts
	$(PHP) $(COMPOSER) update
	$(NPM) update
	$(BOWER) update
	$(NPM) run dev

update-downloaded-dependencies-local: | rm_composer $(COMPOSER) update_deps

update-dependencies-local: update-downloaded-dependencies-local

update_deps_production:
	$(PHP) $(COMPOSER) update --no-plugins --no-scripts --no-dev
	$(PHP) $(COMPOSER) update --no-dev
	$(NPM) update --only=production
	$(BOWER) update
	$(NPM) run production-quiet


update-downloaded-dependencies-production-local: | rm_composer $(COMPOSER) update_deps_production

update-dependencies-production-local: update-downloaded-dependencies-production-local

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

run-mailcatcher-local: $(MAILCATCHER)
	echo "Start mailcatcher"
	$(MAILCATCHER_RUNNER) --ip 127.0.0.1 --smtp-port 1025 --http-port 1080

stop-mailcatcher-local:
	echo "Stop mailcatcher"
	-$(CURL) -v -X DELETE http://127.0.0.1:1080


#----------------------------------------------
#probably TESTS
check-local: $(MAILCATCHER) $(check_SCRIPTS) check_functional

.PHONY: check_functional check-functional-local

check_functional: 
	$(CODECEPT) run functional

check-functional-local: $(MAILCATCHER) $(check_SCRIPTS) check_functional

#codecept acceptance testing ------------------

.PHONY: check_acceptance check-acceptance-local

check-acceptance-local: $(MAILCATCHER) $(check_SCRIPTS) check_acceptance

check_acceptance: 
	$(CODECEPT) run --env phantom acceptance

#clean --------------------------------------
clean-local:
	$(RM) -r composer.phar node_modules vendor


#merge-starterkit---------------------------

merge-starterkit-local: 
	$(GIT) fetch starter-kit
	$(GIT) merge starter-kit/master -m "merging starterkit updates"


#production-optimize ----------------------
ARTISAN = ./artisan

production-optimize-local:
	$(PHP) $(ARTISAN) view:clear
	$(PHP) $(ARTISAN) config:clear
	$(PHP) $(ARTISAN) route:clear
	$(PHP) $(ARTISAN) clear-compiled
	$(PHP) $(COMPOSER) dump-autoload --optimize
	$(PHP) $(ARTISAN) cache:clear
	$(PHP) $(ARTISAN) config:cache
	$(PHP) $(ARTISAN) route:cache
	$(PHP) $(ARTISAN) optimize


#mix handlers
production-mix:
	$(NPM) run production

mix:
	$(NPM) run dev

mix-watch:
	$(NPM) run watch



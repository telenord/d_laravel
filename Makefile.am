
CODECEPT = ./vendor/bin/codecept

check-local: check_functional

.PHONY: check_functional check_codecept

check_functional: check_codecept

check_codecept:
	$(CODECEPT) run functional


download-dependencies-local: composer_install 

COMPOSER = composer.phar

composer_install:
	$(PHP) -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
	$(PHP) composer-setup.php
	$(PHP) -r "unlink('composer-setup.php');"
	$(PHP) $(COMPOSER) install

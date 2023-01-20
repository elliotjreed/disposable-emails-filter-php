.PHONY: all
all: vendor

vendor: composer.json composer.lock
	composer install

.PHONY: test coding-standards unit-tests composer-validate composer-outdated

test: coding-standards unit-tests composer-validate composer-outdated

unit-tests: vendor
	composer run-script phpunit:coverage

debug: vendor
	composer run-script phpunit:debug

coding-standards: vendor
	composer run-script phpcs

composer-validate: vendor
	composer validate --no-check-publish

composer-outdated: vendor
	composer outdated

.PHONY: clean
clean:
	rm -rf build/ vendor/

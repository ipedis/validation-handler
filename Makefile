install:
	composer install

test:
	php vendor/bin/pest

lint:
	php vendor/bin/pint

analyze:
	php vendor/bin/phpstan analyze src demo tests

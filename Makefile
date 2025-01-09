build:
	docker build -t php8.2 .
	docker compose -p bwttest run --rm php composer install

run:
	docker compose -p bwttest run --rm php composer transaction

test:
	docker compose  -p bwttest_test run --rm php composer test

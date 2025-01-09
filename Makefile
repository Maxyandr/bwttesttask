build:
	docker build -t php8.2 .

run:
	docker compose -p bwttest run --rm php composer transaction

test:
	docker compose  -p bwttest_test run --rm php composer test

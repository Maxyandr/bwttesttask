# Test task for bwtgroup


## Building the Project

1. Open terminal.
2. Navigate to the directory where your project is located.
3. You should have installed Docker
4. To build the Docker image for the project, run:

```bash
  make build
```

This command will build a Docker image with the tag `php8.2`.

## Running the Project (Transaction)

Run this command (to proper run environmental variables should be added - see [.env](.env) or [.env.dev](.env.dev)**.env.dev**):

```bash
  make run
```

This command will run the `transaction` Composer script in a Docker container and remove the container afterwards.
By default test file with transaction is used [test_file.txt](test_file.txt)

BinList has limitation of 4 requests per hour for free. I didn't implement authentication for that service. 
Example of header authentication was implemented for Exchange rates based on documentation (for https://api.apilayer.com/exchangerates_data API). 
As I understand it is the same data provider like https://api.exchangeratesapi.io/.

## Testing the Project

Before running the tests, ensure all the Docker containers are up and running. The tests can be run with this command:

```bash
  make test
```

This command will run the `test` Composer script in a Docker container and remove the container after the execution.

## Additional Information

If you found orphan containers from the previous project run, you can clean them up using the following command:

```bash
  docker-compose down --remove-orphans
```

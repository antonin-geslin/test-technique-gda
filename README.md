![App Screenshot](https://user-images.githubusercontent.com/115146768/270640871-5b29ea34-4d7a-41b6-a4ac-5caf82d14039.png)

## Documentation

[Documentation](https://linktodocumentation)

## Installation

Get the project folder

In the .env file describe your databe information in the field DATABASE_URL=""mysql://username:password@127.0.0.1:PORT/dbname?serverVersion=15&charset=utf8"

Persist the entities with :

```bash
  php bin/console make:migration
  php bin/console doctrine:migrations:migrate
```

Load the data in database with Fixtures :

```bash
  php bin/console d:f:l
```

You can now start the local server with :

```bash
  symfony server:start
```

Acess the project by the local adress provide by the terminal !

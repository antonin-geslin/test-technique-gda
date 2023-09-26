![Alt text](/Capture d’écran 2023-09-26 à 13.23.48.png")

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

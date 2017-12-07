# Crypto coin market

## Setup

- Copy `.env.dist` to `.env` and set the parameters
    - `DATABASE_URL`
    - `MAILER_URL`
    - `MAILER_TOMAIL`
    - `MAILER_TONAME`
    - `MAILER_FROMMAIL`
    - `MAILER_FROMNAME`
- Run `bin/console doctrine:database:create` if you havent created your database
- Run `bin/console doctrine:migration:migrate` to setup the schema

## Usage

Run the command

`php bin/console fetch:marketprice`

## Configuration

### Market parser

Right now only one parser is available `cryptocompare`

Create a new one, by creating a new parser in `src/Parser` and implement `App\ParserInterface`

Give it a name, and send the name to the command in the `parser` argument

### Triggers

There are 3 triggers created `low price`, `high price` and `difference price` each can be configured in the command.

Create a new trigger, by creating a new class in `src/Trigger` and implement `App\TriggerInterface`.

### Events

All triggers is sending two events, if the run command returns a array.

Event name: `app.trigger` and `app.trigger.<the trigger name>`

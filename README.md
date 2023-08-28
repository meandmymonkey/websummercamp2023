## Web Summer Camp 2023

# Advanced Symfony Security Workshop

### What is this?

A temporary repository containing material for participants of the workshop
[Advanced Symfony Security Workshop](https://websummercamp.com/2023/workshop/advanced-symfony-security-workshop)
at [Web Summer Camp 2023](https://2023.websummercamp.com/).

### Basic requirements:

#### Hardware: A portable computer

You can (and should!) code along in this workshop. For this, you will
obviously need a laptop computer with your favourite (PHP) development
environment setup. I recommend Linux or macOS. There is no reason why Windows
should not work as well, I just won't be able to answer questions specific
to Docker or PHP on Windows.

#### Knowledge: Docker on your OS

You should feel comfortable using Docker and Docker Compose for local
development. Most of the workshop steps involving docker will be automated,
but when in doubt, you might be required to start and stop containers manually,
and possibly edit port mappings or volumes.

#### Knowledge: PHP

We are going to use PHP 8.2 with some features only available from this
version onward. If you have only used PHP up to 8.0, you will still be fine in
the workshop - but it won't hurt to read up on Readonly Properties, Enums, and
Attributes.

#### Knowledge: Symfony

The focus of this workshop is how to use the Symfony Security component for
authentication and authorization beyond just simple login forms, starting with
the basics, using custom authenticators, and later adding 2FA to our app. We will
also cover some general best practices for Symfony.

However, we will not be able to spend time learning Symfony basics. You should
bring basic working knowledge of a generic Symfony application. Where is
everything, how to configure basic services, etc. Basically, you
should have setup and used the framework before and feel comfortable moving
around the code.

#### Software for your local machine

A REST client like Postman (https://www.postman.com/downloads/) or HTTPie
(https://httpie.io/) is not strictly required, but will make things easier to
use.

We are going to use PostgreSQL - a client like https://tableplus.com/
(Free Trial is fine) can help inspecting the data.

### Workshop Preparation

We are going to use Docker to run some local infrastructure for this workshop.

To minimize setup time during the workshop, and to save the conference network
from huge downloads, please make sure you prepare the following steps before
attending the workshop - better yet, before even travelling to the conference:

- Install a current version of Docker and Docker Compose
- Clone this repository (https://github.com/meandmymonkey/websummercamp2023)
- Run `make init` (if you have `make` on your system) or `docker compose build --pull --no-cache && docker compose up --detach`
- Enter the container using `make sh` (or `docker compose exec php sh`) and run `composer install` and `bin/console d:m:m -n` to bootstrap the application

**Note:** This dev setup is based on [Symfony Docker](https://github.com/dunglas/symfony-docker).
Please see the corresponding section on trusting the generated [Certificates](https://github.com/dunglas/symfony-docker/blob/main/docs/tls.md).

#### Alternative: Running locally

If you prefer running a local PHP installation with the Symfony CLI (for example, on macOS), You can use Docker just for
the database. For this to work, you'll need to add a `.env.local` to override the ports published by Docker **This is entirely optional.**

If you want to do so, you will need some stuff in addition to Docker and Docker Compose:

- Composer (https://getcomposer.org/)
- The Symfony CLI (https://symfony.com/download)

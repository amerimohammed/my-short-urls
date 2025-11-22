# Basic Short URLs project:

In this web app, anyone can register and manage his/her own short urls. In case of unauthenticated users, they can only use the end point (/redirect/{shortUrl}) to be redirected to the original url. Or they can access the api (/api/decode/{shortUrl}) to get the original url in JSON object.

## Installation and Instructions:

**Prerequisites:**

PHP, Mysql, Composer, and Symfony.

**Instructions:**

- Change database settings in .env file to your own settings.

- composer install

- symfony console doctrine:database:create

- symfony console doctrine:migrations:migrate

- symfony server:start

# Ultimaterial - template for OpenCart 3.1

## Development
1. Clone this project.
2. Copy the `.env.example` file and rename it to `.env` (Edit the final file as you like).
3. Install [Docker](https://www.docker.com/get-started).
4. Open the console at the root of the project.
5. Run the `docker-compose build` command and wait for the build to complete.
6. Run the `docker-compose up -d` command.
7. Run the `docker-compose exec php bash` command.
8. Run the `composer install` command and wait for the installation to complete.
9. Run the `composer exec robo opencart:install` command and wait for the installation to complete.
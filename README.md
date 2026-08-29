# support-system-coding-test
PHP/Web Coding Test. This app build for interview.

## Setup


```bash
# 1. Copy the environment file
cp .env.example .env

# 2. Build and start the containers (app, webserver, db, mailpit, queue)
docker compose up -d --build

# 3. Install PHP dependencies
docker compose exec app composer install

# 4. Generate an app key 
docker compose exec app php artisan key:generate

# 5. Run migrations and seed demo data (users, tickets, replies)
docker compose exec app php artisan migrate --seed

# 6. Install and build frontend assets (on the host, not in the container)
npm install
npm run build
```

Once running:
- App: http://localhost:8001
- Mailpit (catches outgoing email): http://localhost:8025
- MySQL is exposed on host port `3308` (maps to container port `3306`)

# Screenshots
![Ticket Open Page](screenshots/Ticket_Open_Page.PNG)
#
![Ticket Open Page](screenshots/Login_Page.PNG)
#
![Ticket Open Page](screenshots/Ticket_Status_Check_Page.PNG)



# Some codes gets by laravel offical documentaion
https://laravel.com/framework/docs/installation

# Docker setup refferance site
https://docs.docker.com/guides/laravel/

# Frontend design used tailwindcss
- css styles get from offical site.
https://tailwindcss.com/docs/installation/using-vite

# Artisan Commands That Used For Develope This App 

Migration & Seeds
------------------
- docker compose exec app php artisan make:migration create_tickets_table
- docker compose exec app php artisan make:migration create_ticket_replies_table
- docker compose exec app php artisan migrate --seed


Models
---------
- docker compose exec app php artisan make:model Ticket
- docker compose exec app php artisan make:model TicketReply

Enums
---------
- docker compose exec app php artisan make:enum Enums/TicketStatus

Providers
---------
- docker compose exec app php artisan make:provider RepositoryServiceProvider

Mailables
---------
- docker compose exec app php artisan make:mail TicketAcknowledgement --markdown=emails.tickets.acknowledgement
- docker compose exec app php artisan make:mail TicketReplied --markdown=emails.tickets.replied

Seeders
--------
- docker compose exec app php artisan make:seeder UserSeeder

Controllers
--------
- docker compose exec app php artisan make:controller Auth/LoginController
- docker compose exec app php artisan make:controller TicketController
- docker compose exec app php artisan make:controller Agent/TicketController


Form Requests - validation
--------
- docker compose exec app php artisan make:request StoreTicketRequest
- docker compose exec app php artisan make:request StoreReplyRequest
- docker compose exec app php artisan make:request CheckStatusRequest
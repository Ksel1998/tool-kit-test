install:
	composer install,
	cp .env.example .env
	php artisan migrate --seed
	php artisan key:generate

clear:
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
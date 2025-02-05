install:
	composer install,
	cp .env.example .env
	php artisan migrate --seed
	php artisan key:generate
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	php artisan l5-swagger:generate

clear:
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear

serve:
	php artisan serve --port=8008
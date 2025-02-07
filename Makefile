# Создание и настройка тестовой базы данных
# Выполнять, если нужны быстрые тесты
db-settings:
	@echo "Создание тестовой базы данных tool_kit_db..."
	sudo psql -h 127.0.0.1 -U postgres -c "CREATE DATABASE tool_kit_db;"

	@echo "Создание пользователя tool_kit_user..."
	sudo psql -h 127.0.0.1 -U postgres -c "CREATE USER tool_kit_user WITH PASSWORD '123';"

	@echo "Предоставление прав пользователю tool_kit_user..."
	sudo psql -h 127.0.0.1 -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE tool_kit_db TO tool_kit_user;"

# Первоначальная настройка проекта после скачивания из gitHub
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

# Полная очистка кэша
clear:
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear

# Запуск через artisan на конкретном порте
serve:
	php artisan serve --port=8008

# Быстрая настройка
fast-setting:
	db-settings
	install
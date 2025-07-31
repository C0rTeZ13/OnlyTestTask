## Описание
Проект реализован с использованием Docker и Laravel. Для запуска используется Docker Compose.

## Настройка окружения
Перед запуском создайте файлы `.env` и `.env.testing` на основе `.env.example` и при необходимости настройте параметры окружения.
В частности выполните:
```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
docker exec only-app-1 php artisan migrate
```

## Запуск проекта
Команда для сборки и запуска проекта:
```bash
docker compose up -d --build
```

В результате будет поднято три контейнера:
- **only-app-1**,
- **only-webserver-1**,
- **only-db-1**

## Заполнение данными (Seeder)
Чтобы заполнить БД данными для ручных тестов, нужно выполнить:
```bash
docker exec only-app-1 php artisan db:seed
```

## Интерактивная документация Swagger
Доступна по адресу:
```bash
http://localhost:8000/api-docs
```

## Тесты
Для запуска:
```bash
php artisan jwt:secret --env=testing
docker exec only-app-1 composer test
```
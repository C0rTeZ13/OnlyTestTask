## Описание
Проект реализован с использованием Docker и Laravel. Для запуска используется Docker Compose.

## Запуск проекта
```bash
git clone git@github.com:C0rTeZ13/OnlyTestTask.git
cd OnlyTestTask
```
Команда для сборки и запуска проекта:
```bash
docker compose up -d --build
```

В результате будет поднято три контейнера:
- **only-app-1**,
- **only-webserver-1**,
- **only-db-1**

## Настройка окружения
Создайте файлы `.env` и `.env.testing` на основе `.env.example` и при необходимости настройте параметры окружения.
В частности выполните:
```bash
docker exec only-app-1 php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
docker exec only-app-1 php artisan jwt:secret
docker exec only-app-1 php artisan migrate
```

## Заполнение данными (Seeder)
Чтобы заполнить БД подготовленными данными для ручных тестов, можно выполнить:
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
docker exec only-app-1 php artisan jwt:secret --env=testing
docker exec only-app-1 composer test
```
Также тесты запускаются pre-push хуком.

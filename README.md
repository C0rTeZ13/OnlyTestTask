## Описание
Проект реализован с использованием Docker и Laravel. Для запуска используется Docker Compose.
Ссылка на [тестовое задание](https://recrus.yonote.ru/share/f04cc23c-d495-4f5d-96bc-450afbc4e019).

## Настройка окружения
Перед запуском создайте файл `.env` на основе `.env.example` и при необходимости настройте параметры окружения.

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
Чтобы заполнить БД данными для ручных тестов нужно выполнить:
```bash
docker exec only-app-1 php artisan migrate
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
docker exec only-app-1 composer test
```
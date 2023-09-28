# REST API Приложение
Развертывание приложения:
```
git clone https://github.com/Yauheni-Panov/systemeoi_test.git

docker-compose up --build -d

docker exec -it web bash

composer install

bin/console doctrine:database:create

bin/console doctrine:migrations:migrate

```
Апи эндпоинты:

1) Рассчет стоимости товара. 

Route: "http://127.0.0.1:80/calculate-price"

Пример json тела:
```
   {
        "product": "1",
        "taxNumber": "DE123456789",
        "couponCode": "D10"
    }
```
2) Покупка товара :

Route: "http://127.0.0.1:80/purchase"

Пример json тела:
```
   {
        "product": "1",
        "taxNumber": "DE123456789",
        "couponCode": "D10",
        "paymentProcessor": "stripe"
    }
```

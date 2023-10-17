# Учет трафика клиентов #

### Установка ###
```bash
git clone git@github.com:megoskot/client_traffic.git
cd client_traffic
sh install.sh
```
Зауск комманды для инициализации данных в начале месяца:
```bash
php bin/console app:month:start
```

Запуск миграций:
```bash
php bin/console doctrine:migrations:migrate
```
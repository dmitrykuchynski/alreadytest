# Alreadytest

Проект WordPress для отображения каталога автомобилей.
## Быстрый старт

### 1. Клонируй проект

```bash
git clone git@github.com:dmitrykuchynski/alreadytest.git
cd alreadytest
```
### 2. Создай .env файл в корне
Пример содержимого:

.env:

MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=wordpress
MYSQL_USER=wpuser
MYSQL_PASSWORD=wppass

WORDPRESS_DB_HOST=db:3306
WORDPRESS_DB_NAME=wordpress
WORDPRESS_DB_USER=wpuser
WORDPRESS_DB_PASSWORD=wppass

### 3. Запусти WordPress через Docker
```bash
docker-compose up --build
```
База данных в папке db в корне

WordPress будет доступен по адресу: http://localhost:8000

phpMyAdmin доступен по адресу: http://localhost:8080

### 4. Установка зависимостей темы
Перейди в директорию кастомной темы:

cd wp-content/themes/alreadytest/webpack
```bash
npm install
```
### 5. Сборка ассетов
Production:
```bash
npm run build
```
Development (с автообновлением и BrowserSync):
```bash
npm run watch
```

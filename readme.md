# Лабораторная работа №5: Запуск сайта в контейнере

## Студент

**Питропов Александр, группа I2302**  
**Дата выполнения: _23.03.2025_**

## Цель работы

Подготовка образа контейнера для запуска веб-сайта на базе **Apache HTTP Server** + **PHP (mod_php)** + **MariaDB**.

## Задание

1. Создать **Dockerfile** для сборки контейнера с **Apache HTTP Server**, **PHP (mod_php)** и **MariaDB**.
2. База данных **MariaDB** должна храниться в монтируемом томе.
3. Сервер должен быть доступен по порту **8000**.
4. Установить **WordPress** и проверить его работоспособность.

## Ход работы

### 1. Создание и клонирование репозитория

Создан репозиторий `containers05` и склонирован на локальный компьютер.

### 2. Извлечение конфигурационных файлов

Созданы папки для хранения конфигурационных файлов:
```sh
mkdir -p files/apache2 files/php files/mariadb
```

Создан `Dockerfile` со следующим содержимым:
```dockerfile
FROM debian:latest
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server && \
    apt-get clean
```

Построен образ контейнера:
```sh
docker build -t apache2-php-mariadb .
```

Запущен контейнер:
```sh
docker run -d --name apache2-php-mariadb apache2-php-mariadb bash
```

Скопированы конфигурационные файлы из контейнера:
```sh
docker cp apache2-php-mariadb:/etc/apache2/sites-available/000-default.conf files/apache2/
docker cp apache2-php-mariadb:/etc/apache2/apache2.conf files/apache2/
docker cp apache2-php-mariadb:/etc/php/8.2/apache2/php.ini files/php/
docker cp apache2-php-mariadb:/etc/mysql/mariadb.conf.d/50-server.cnf files/mariadb/
```

Контейнер остановлен и удалён:
```sh
docker stop apache2-php-mariadb
docker rm apache2-php-mariadb
```

### 3. Настройка конфигурационных файлов

#### Конфигурация **Apache2**

Изменения в `files/apache2/000-default.conf`:
```apache
ServerName localhost
DirectoryIndex index.php index.html
ServerAdmin your_email@example.com
```

Изменения в `files/apache2/apache2.conf`:
```apache
ServerName localhost
```

#### Конфигурация **PHP**

Изменения в `files/php/php.ini`:
```ini
error_log = /var/log/php_errors.log
memory_limit = 128M
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 120
```

#### Конфигурация **MariaDB**

Изменения в `files/mariadb/50-server.cnf`:
```ini
log_error = /var/log/mysql/error.log
```

### 4. Создание скрипта запуска `supervisord.conf`

Создан файл `files/supervisor/supervisord.conf`:
```ini
[supervisord]
nodaemon=true
logfile=/dev/null
user=root

[program:apache2]
command=/usr/sbin/apache2ctl -D FOREGROUND
autostart=true
autorestart=true
user=root

[program:mariadb]
command=/usr/sbin/mariadbd --user=mysql
autostart=true
autorestart=true
user=mysql
```

### 5. Доработка `Dockerfile`

Изменён `Dockerfile`:
```dockerfile
FROM debian:latest
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor && \
    apt-get clean

VOLUME /var/lib/mysql
VOLUME /var/log

ADD https://wordpress.org/latest.tar.gz /var/www/html/

COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY files/apache2/apache2.conf /etc/apache2/apache2.conf
COPY files/php/php.ini /etc/php/8.2/apache2/php.ini
COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
COPY files/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

RUN mkdir /var/run/mysqld && chown mysql:mysql /var/run/mysqld
EXPOSE 80
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
```

### 6. Запуск контейнера и настройка WordPress

Запуск контейнера:
```sh
docker build -t apache2-php-mariadb .
docker run -d --name apache2-php-mariadb -p 8000:80 apache2-php-mariadb
```

Создание базы данных и пользователя:
```sh
docker exec -it apache2-php-mariadb mysql -e "CREATE DATABASE wordpress;"
docker exec -it apache2-php-mariadb mysql -e "CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';"
docker exec -it apache2-php-mariadb mysql -e "GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';"
docker exec -it apache2-php-mariadb mysql -e "FLUSH PRIVILEGES;"
```

Копирование `wp-config.php` в `files/wp-config.php`, затем его добавление в `Dockerfile`:
```dockerfile
COPY files/wp-config.php /var/www/html/wordpress/wp-config.php
```

### 7. Итоговый запуск и тестирование

Пересборка образа и запуск:
```sh
docker build -t apache2-php-mariadb .
docker run -d --name apache2-php-mariadb -p 8000:80 apache2-php-mariadb
```

Открытие в браузере: `http://localhost:8000`

## Выводы

1. Были изменены файлы конфигурации **Apache2**, **PHP** и **MariaDB**.
2. Инструкция `DirectoryIndex` задаёт список файлов, которые будут открываться по умолчанию.
3. `wp-config.php` хранит параметры подключения WordPress к базе данных.
4. `post_max_size` в **PHP** определяет максимальный размер данных, передаваемых методом POST.
5. Недостатки контейнера:
   - Не настроены безопасные пароли для базы данных.
   - Не предусмотрены механизмы резервного копирования данных.
   - Используется `latest`-тег образа, что может привести к несовместимостям в будущем.

Работа выполнена успешно, WordPress установлен и работает в контейнере.


## Библиография

- [Docker Documentation](https://docs.docker.com/get-started/overview/)
- [Apache HTTP Server Documentation](https://httpd.apache.org/docs/2.4/)
- [PHP Manual](https://www.php.net/manual/en/ini.core.php)
- [MariaDB Documentation](https://mariadb.com/kb/en/mariadb-documentation/)
- [WordPress Documentation](https://wordpress.org/support/article/how-to-install-wordpress/)
- [Supervisor Documentation](http://supervisord.org/)

<?php
// Создаём объект подключения к QSLite
$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
// Вставляем строчку в таблицу пользователей
$connection->exec(
    "INSERT INTO users (first_name, last_name) VALUES ('Nikita', 'Kapurin')"
);
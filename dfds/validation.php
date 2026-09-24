<?php

function validateEmail($email) {
    $email = trim($email);
    if (empty($email)) {
        return 'Email обязателен для заполнения';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите корректный email адрес';
    }
    return null;
}

function validateName($name) {
    $name = trim($name);
    if (empty($name)) {
        return 'Имя обязательно для заполнения';
    }
    if (strlen($name) < 2) {
        return 'Имя должно содержать не менее 2 символов';
    }
    if (strlen($name) > 50) {
        return 'Имя не должно превышать 50 символов';
    }
    if (!preg_match('/^[а-яА-Яa-zA-Z\s\-]+$/u', $name)) {
        return 'Имя может содержать только буквы, пробелы и дефисы';
    }
    return null;
}

function validatePassword($password) {
    if (empty($password)) {
        return 'Пароль обязателен для заполнения';
    }
    if (strlen($password) < 6) {
        return 'Пароль должен содержать не менее 6 символов';
    }
    return null;
}

function validateTaskTitle($title) {
    $title = trim($title);
    if (empty($title)) {
        return 'Название задачи обязательно';
    }
    if (strlen($title) < 3) {
        return 'Название должно содержать не менее 3 символов';
    }
    if (strlen($title) > 100) {
        return 'Название не должно превышать 100 символов';
    }
    return null;
}

function collectErrors($validations) {
    $errors = [];
    foreach ($validations as $field => $result) {
        if ($result !== null) {
            $errors[$field] = $result;
        }
    }
    return $errors;
}
?>
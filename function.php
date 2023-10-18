<?php
session_start();

function checkLogin($pdo, $id, $password) {
    $account = findAccountByName($pdo, $id);
    return !empty($account) && password_verify($password, $account['password']) ? $account : false;
}

function findAccountByName($pdo, $id) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$id]);
    return $sth->fetch();
}

function checkDeplicateAccount($pdo, $name) {
    $sth = $pdo->prepare("SELECT * FROM accounts WHERE `name` = ?");
    $sth->execute([$name]);
    $result = $sth->fetchAll();
    return count($result) === 0;
}

function saveAccount($pdo, $name, $password, $isAdmin) {
    $sth = $pdo->prepare("INSERT INTO `accounts` (`name`, `password`, admin_flag) VALUE(?, ?, ?)");
    return $sth->execute([$name, password_hash($password, PASSWORD_BCRYPT), $isAdmin ? 1 : 0]);
}

function deleteBbs($pdo, $id) {
    $sth = $pdo->prepare("DELETE FROM comments WHERE id = ?;");
    return $sth->execute([$id]);
}

function dbConnect() {
    $pdo = new PDO("mysql:host=mysql;dbname=bbs", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}
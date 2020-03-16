<?php

include_once("./src/Database.php");

use Database\MySQL;

// Connection
$database = new MySQL();
$database->setServer("127.0.0.1");
$database->setUsername("admin");
$database->setPassword("w0nderL@nd");
$database->setDatabase("test_db");

// Create table
$database->createTable("users", [
    $database->typeString("email"),
    $database->typeString("password", 40),
    $database->typeString("token", 40)
]);

// Insert data

$database->insertInto("users", [
    "email" => "hej@johannmalm.com"
]);

// Update data

$database->update("users", [
    "password" => sha1("1234")
], [
    "id" => 1
]);

// Delete data

$database->deleteFrom("users", 5);

// Select data

$database->selectFrom("users", [
    "email" => "hej@johannmalm.com"
]);

// Search data

$database->searchFrom("users", [
    "created_at" => "20"
]);

// Handle responses

if ($database->getError() !== null) {
    exit($database->getError());
}

print_r($database->getResult());

?>
<?php

require_once './vendor/autoload.php';
require_once './components.php';

use Database\MySQL;
use UI\Tag;
use Router\Route;

$meta = [
   "author" => "Johann Malm", 
   "description" => "A new framework.", 
   "keywords" => [
       "framework",
       "johann malm",
       "php"
   ]
];

Route::get("/", function() use ($meta) {
   return view("Hello, world!", [
       centerBox(
           "Framework",
           "Made by <a href='mailto:hej@johannmalm.com'>Johann Malm</a>",
           [
               ["database", "https://packagist.org/packages/johannmalmcom/database"],
               ["router", "https://packagist.org/packages/johannmalmcom/router"],
               ["ui", "https://packagist.org/packages/johannmalmcom/ui"],
           ]
       )
   ], $meta);
});

?>
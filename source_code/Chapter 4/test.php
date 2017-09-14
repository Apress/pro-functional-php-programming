<?php

require('MonadPHP/Monad.php');
require('MonadPHP/Maybe.php');
require('MonadPHP/ListMonad.php');

use MonadPHP\Maybe;
use MonadPHP\ListMonad;


$posts = array(
    array("title" => "foo", "author" => array("name" => "Bob", "email" => "bob@example.com")),
    array("title" => "bar", "author" => array("name" => "Tom", "email" => "tom@example.com")),
    array("title" => "baz"),
    array("title" => "biz", "author" => array("name" => "Mark", "email" => "mark@example.com")),
);


function index($key) {
    return function($array) use ($key) {
        return isset($array[$key]) ? $array[$key] : null;
    };
}


$postMonad = new MonadPHP\ListMonad($posts);
$names = $postMonad
    ->bind(MonadPHP\Maybe::unit)
    ->bind(index("author"))
    ->bind(index("name"))
    ->extract();

print_r($names);

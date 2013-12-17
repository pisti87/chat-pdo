<?php
session_start();
require 'connect/database.php';
require 'classes/users.php';
require 'classes/messages.php';

$users = new User($db);
$messages = new Message($db);
$errors = array();
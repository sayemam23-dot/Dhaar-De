<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);

require 'views/index.html.php';

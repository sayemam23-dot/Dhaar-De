<?php
session_start();
session_unset();
session_destroy();
header('Location: /dhaar-de/login.php');
exit;

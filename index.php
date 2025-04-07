<?php
// index.php
require_once 'config/init.php';

if (isLoggedIn()) {
    header("Location: views/dashboard.php");
} else {
    header("Location: views/auth/login.php");
}
exit; 

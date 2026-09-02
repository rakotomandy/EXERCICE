<?php
require_once 'Core/Autoloader.php'; 

if(isset($_GET['action'])) {
    Root::connect($_GET['action']);
} else {
    echo "NOT FOUND";
}
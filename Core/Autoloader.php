<?php
define('URL', 'http://localhost/ExoCrud/');
session_start();
/**
 * @param string $file
 */
    function autoload($file) {
       if(file_exists('Core/' . $file . '.php')) {
            require_once 'Core/' . $file . '.php';
        } else if(file_exists('Models/' . $file . '.php')) {
            require_once 'Models/' . $file . '.php';
        } else if(file_exists('Controllers/' . $file . '.php')) {
            require_once 'Controllers/' . $file . '.php';
        }
        }
  

    spl_autoload_register('autoload');
    

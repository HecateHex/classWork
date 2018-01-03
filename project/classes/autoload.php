<?php
spl_autoload_register(function ($class) {
   $path = str_replace('\\','/',$class);
   include(__DIR__ ."/$path.php");
});
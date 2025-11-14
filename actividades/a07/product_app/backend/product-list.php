<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Read\Read;

    $read = new Read();
    
    $read->list();

    echo $read->getData();
?>
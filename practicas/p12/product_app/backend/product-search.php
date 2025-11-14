<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Read\Read;
    $read = new Read();
    
    if(isset($_GET['search'])) {
        $read->search($_GET['search']);
    }
    echo $read->getData();
?>
<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Read\Read;

    $read = new Read();
    
    if(isset($_POST['id'])) {
        $read->single($_POST['id']);
    }
    echo $read->getData();
?>
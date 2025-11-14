<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Delete\Delete;
    $delete = new Delete();
    if(isset($_POST['id'])) {
        $delete->delete($_POST['id']);
    }
    echo $delete->getData();
?>
<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Update\Update;
    $update = new Update();

    if(isset($_POST['id'])) {
        $producto = json_decode(json_encode($_POST));
        
        $update->edit($producto);
    }
    echo $update->getData();
?>
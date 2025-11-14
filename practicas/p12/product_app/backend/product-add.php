<?php
  
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use App\Create\Create;

    $create = new Create();

    if(isset($_POST['nombre'])) {
       
        $producto = json_decode(json_encode($_POST));  
        
        $create->add($producto);
    }
    echo $create->getData();
?>
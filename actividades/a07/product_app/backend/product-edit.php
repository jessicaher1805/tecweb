<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $prodObj->edit(file_get_contents('php://input'));

    echo $prodObj->getData();
?>
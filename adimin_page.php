<?php
    require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aministrador</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <h3>Adcionar novo produto</h3>
                <input type="text" placeholder="Adicione o nome do produto" name="product_name" class="box">
                <input type="number" placeholder="Adicione o preço do produto" name="product_price" class="box">
                <input type="file" accept="iamge/png, image/jpeg, image/jpg"  name="product_image" class="box">
                <input type="submit" value="Adicionar" class="btn" name="add_product">

            </form>
        </div>
    </div>
</body>
</html>
<?php
    require_once 'config.php';

    $id = $_GET['edit'];
    if (isset($_POST['update_product']))
    {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder= 'uploaded_img/'.$product_image;

        if(empty($product_name)|| empty($product_price) || empty($product_image) ){
            $message[] = 'Por favor, envie todos os dados requeridos';
        }else{
            $update = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image' WHERE id = $id";
            $upload = mysqli_query($conn,$update);
            if($upload){
                move_uploaded_file($product_image_tmp_name,$product_image_folder);                
            }else{
                $message[] = 'Não foi possível adicionar o produto!';
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
    
    if (isset($message)){
        foreach ($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
    } 
    ?>
    <div class="container">
        <div class="admin-product-form-container centered">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM  products WHERE id = $id");
            while ($row = mysqli_fetch_assoc($select)){
            ?>
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <h3>Atualize o produto</h3>
                <input type="text" placeholder="Adicione o nome do produto" name="product_name" class="box" value="<?=$row['name'];?>">
                <input type="number" placeholder="Adicione o preço do produto" name="product_price" class="box" value="<?=$row['price'];?>">
                <input type="file" accept="iamge/png, image/jpeg, image/jpg"  name="product_image" class="box">
                <input type="submit" value="Atualizar" class="btn" name="update_product" >
                <a href="admin_page.php" class="btn"><i class="fa-solid fa-circle-arrow-left"></i> Voltar</a>

            </form>
            <?php }?>
        </div>
    </div>
    
</body>
</html>
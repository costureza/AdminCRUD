<?php
    require_once 'config.php';
    if (isset($_POST['add_product']))
    {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder= 'uploaded_img/'.$product_image;

        if(empty($product_name)|| empty($product_price) || empty($product_image) ){
            $message[] = 'Por favor, envie todos os dados requeridos';
        }else{
            $insert = "INSERT INTO products (name, price, image) VALUES ('$product_name', '$product_price', '$product_image')";
            $upload = mysqli_query($conn,$insert);
            if($upload){
                move_uploaded_file($product_image_tmp_name,$product_image_folder);
                $message[] = 'Novo produto adicionado!';
            }else{
                $message[] = 'Não foi possível adicionar o produto!';
            }
        }
    }

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    if(is_numeric($id)) { // Verifica se o ID é numérico
        // Verifica se o produto existe antes de deletar
        $check = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        if(mysqli_num_rows($check) > 0) {
            $delete = mysqli_query($conn, "DELETE FROM products WHERE id = $id");
            if($delete){
                header('Location: admin_page.php');
                exit;
            } else {
                $message[] = 'Erro ao deletar produto: ' . mysqli_error($conn);
            }
        } else {
            $message[] = 'Produto não encontrado!';
        }
    } else {
        $message[] = 'ID inválido!';
    }
}

// Exibir mensagem de sucesso se o parâmetro deleted estiver presente
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $message[] = 'Produto deletado com sucesso!';
}
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
    <?php
    
    if (isset($message)){
        foreach ($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
    } 
    ?>
    
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
        <?php
        $select = mysqli_query($conn, "SELECT * FROM products");        
        ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>Imagem</td>
                        <td>Nome</td>
                        <td>Preço</td>
                        <td> Ações</td>
                    </tr>
                </thead>
                <?php
                while ($row = mysqli_fetch_assoc($select)){?>
                    <tr>
                        <td><img src="./uploaded_img/<?=$row['image'];?>" height="100" alt=""></td>
                        <td><?=$row['name'];?></td>
                        <td><?=$row['price'];?></td>
                        <td><a class="btn" href="admin_update.php?edit=<?=$row['id'];?>"><i class="fas fa-edit"></i>Edit</a>
                        <a class="btn" href="admin_page.php?delete=<?=$row['id'];?>"><i class="fas fa-trash"></i>Delete</a></td>
                    </tr>                
                
                <?php }; ?>

            </table>
        </div>
    </div>
</body>
</html>
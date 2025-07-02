<?php
require_once 'config.php';

// Verifica se o ID é numérico e existe no banco
$id = isset($_GET['edit']) && is_numeric($_GET['edit']) ? (int)$_GET['edit'] : 0;
$select = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
if(mysqli_num_rows($select) === 0) {
    header('Location: admin_page.php?error=Produto não encontrado');
    exit;
}

if (isset($_POST['update_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = (float)$_POST['product_price'];
    
    // Mantém a imagem atual se não for enviada nova
    if(!empty($_FILES['product_image']['name'])) {
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'uploaded_img/'.$product_image;
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
    } else {
        // Pega a imagem atual do banco
        $current = mysqli_fetch_assoc($select);
        $product_image = $current['image'];
    }

    if(empty($product_name) || empty($product_price)) {
        $message[] = 'Por favor, preencha todos os campos obrigatórios';
    } else {
        $update = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image' WHERE id = $id";
        if(mysqli_query($conn, $update)) {
            $message[] = 'Produto atualizado com sucesso!';
            // Atualiza os dados exibidos no formulário
            $select = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        } else {
            $message[] = 'Erro ao atualizar produto: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- ... (cabeçalho mantido igual) ... -->
</head>
<body>
    <?php
    if (isset($message)){
        foreach ($message as $msg){
            echo '<span class="message">'.$msg.'</span>';
        }
    } 
    ?>
    <div class="container">
        <div class="admin-product-form-container centered">
            <?php
            $row = mysqli_fetch_assoc($select);
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Atualize o produto</h3>
                <input type="text" placeholder="Nome do produto" name="product_name" class="box" value="<?= htmlspecialchars($row['name']) ?>">
                <input type="number" step="0.01" placeholder="Preço do produto" name="product_price" class="box" value="<?= htmlspecialchars($row['price']) ?>">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <p>Imagem atual: <?= $row['image'] ?></p>
                <input type="submit" value="Atualizar" class="btn" name="update_product">
                <a href="admin_page.php" class="btn"><i class="fa-solid fa-circle-arrow-left"></i> Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>
<?php
session_start();

require_once("inc/Database.php");
require_once("inc/dynamic_elements.php");

// Instância da classe Database para interação com o banco de dados
$db = new Database();

// Verificar a ação a ser realizada
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'removeItem':
            // Remover item do carrinho
            if (isset($_GET['id'])) {
                unset($_SESSION['cart'][$_GET['id']]);
                echo "<script>alert('O produto foi removido do seu carrinho!')</script>";
            }
            break;
        case 'update_qty':
            // Atualizar a quantidade do item no carrinho
            if (isset($_GET['pid']) && isset($_GET['operation'])) {
                $pid = $_GET['pid'];
                $operation = $_GET['operation'];
                if ($operation == "add") {
                    $_SESSION['cart'][$pid] += 1;
                } else {
                    if ($_SESSION['cart'][$pid] > 1) {
                        $_SESSION['cart'][$pid] -= 1;
                    }
                }
            }
            break;
        // Adicione mais casos para ações adicionais, se necessário
        default:
            // Lidar com ações desconhecidas ou não fazer nada
            break;
    }

    // Redirecionar de volta para cart.php após processar a ação
    header('location: ./cart.php');
}

// O restante do código existente para exibir o carrinho e o conteúdo HTML 
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrinho</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php
// Incluir o cabeçalho da página
require_once('inc/header.php');
?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h2>Meu carrinho</h2>
                <hr>
                <?php

                $total = 0;

                // Verificar se há itens no carrinho
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    $pids = array_keys($_SESSION['cart']);

                    // Obter dados dos produtos no carrinho
                    $result = $db->getData($pids);

                    // Iterar sobre os resultados e exibir os itens no carrinho
                    while ($row = $result->fetch_assoc()) {
                        cartItems($row);

                        // Verificar se a chave existe antes de usá-la
                        $productId = $row['id'];
                        $quantity = isset($_SESSION['cart'][$productId]) ? intval($_SESSION['cart'][$productId]) : 0;

                        $total += (floatval($row['current_price']) * $quantity);
                    }
                } else {
                    // Exibir mensagem se o carrinho estiver vazio
                    echo "<div class='shopping-cart'>";
                    echo "<h5>O carrinho está vazio!</h5>";
                    echo "</div>";
                }
                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

            <div class="pt-4">
                <h5>Total</h5>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        // Exibir o número de itens no carrinho
                        if (isset($_SESSION['cart'])) {
                            $count = count($_SESSION['cart']);
                            echo "<h6>Preço ($count itens)</h6>";
                        } else {
                            echo "<h6>Preço (0 itens)</h6>";
                        }
                        ?>
                        <h6>Frete</h6>
                        <hr>
                        <h6>Valor total</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>R$<?php echo number_format($total, 2); ?></h6>
                        <h6 class="text-success">GRÁTIS</h6>
                        <hr>
                        <h6>R$<?php
                            echo number_format($total, 2);
                            ?></h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts Bootstrap e jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>

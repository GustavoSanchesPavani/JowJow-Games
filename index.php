<?php

session_start();

require_once('inc/Database.php');
require_once('inc/dynamic_elements.php');

// Criar instância da classe Database
$database = new Database();

// Adicionar item ao carrinho se o formulário for enviado
if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {

        if (in_array($_POST['product_id'], array_keys($_SESSION['cart']))) {
            $_SESSION['cart'][$_POST['product_id']] += 1;
            header("location: ./");
        } else {
            // Criar nova variável de sessão
            $_SESSION['cart'][$_POST['product_id']] = 1;
            // header("location: ./"); // Não é necessário redirecionar aqui, pois a página atualiza após o envio do formulário
        }

    } else {
        // Criar nova variável de sessão
        $_SESSION['cart'][$_POST['product_id']] = 1;
        // header("location: ./"); // Não é necessário redirecionar aqui, pois a página atualiza após o envio do formulário
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JowJow Games</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css"/>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php require_once("inc/header.php"); ?>
<div class="container">
    <div class="row text-center py-5">
        <?php
        // Obter dados dos produtos
        $result = $database->getData();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Renderizar elemento do produto
                prodElement($row);
            }
        } else {
            echo "<h4 class='text-center'>Nenhum produto listado ainda</h4>";
        }
        ?>
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

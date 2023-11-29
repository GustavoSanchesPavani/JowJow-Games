<!-- O bloco abaixo representa o cabeçalho da página -->
<header id="header">
    <!-- Barra de navegação com estilo escuro -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Link para a página inicial com o logotipo -->
        <a href="index.php" class="navbar-brand">
            <!-- Título estilizado com espaçamento à direita -->
            <h3 class="px-5">
                <!-- Ícone e texto do logotipo -->
                <img src="upload/icon.png" width="40" style="background: none;"> JowJow Games
            </h3>
        </a>
        <!-- Botão de alternância para exibir o menu em telas menores -->
        <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <!-- Ícone para o botão de alternância -->
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Área do menu de navegação -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <!-- Espaçador à esquerda para alinhar elementos corretamente -->
            <div class="mr-auto"></div>
            <!-- Itens do menu de navegação -->
            <div class="navbar-nav">
                <!-- Link para a página do carrinho com ícone e contador -->
                <a href="cart.php" class="nav-item nav-link active">
                    <!-- Título estilizado com espaçamento à direita -->
                    <h5 class="px-5 cart">
                        <!-- Ícone do carrinho de compras -->
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                        // Verifica se existe uma sessão de carrinho
                        if (isset($_SESSION['cart'])){
                            $count = 0;
                            // Calcula a quantidade total de itens no carrinho
                            foreach($_SESSION['cart'] as $v){
                                $count += $v;
                            }
                            // Exibe o contador de itens no carrinho
                            echo "<span id=\"cart_count\" class=\"text-light bg-danger rounded-0\">$count</span>";
                        }else{
                            // Se não houver itens no carrinho, exibe 0
                            echo "<span id=\"cart_count\" class=\"text-light bg-danger rounded-0\">0</span>";
                        }
                        ?>
                        <!-- Texto indicando a função do link -->
                        Carrinho
                    </h5>
                </a>
            </div>
        </div>
    </nav>
</header>

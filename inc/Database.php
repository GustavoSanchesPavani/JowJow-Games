<?php

// Classe para interação com o banco de dados
class Database
{
    // Propriedades da classe para configuração do banco de dados
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $conn;

    // Construtor da classe
    public function __construct(
        $dbname = "jowjow_games",
        $tablename = "products",
        $servername = "localhost",
        $username = "root",
        $password = ""
    )
    {
        // Inicialização das propriedades
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;

        // Criação da conexão com o banco de dados
        $this->conn = new mysqli($servername, $username, $password);

        // Verifica se a conexão foi estabelecida com sucesso
        if (!$this->conn) {
            die("Connection failed: " . $this->conn->error);
        }

        // Query para criar o banco de dados se não existir
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        // Executa a query
        if ($this->conn->query($sql)) {

            // Estabelece a conexão com o banco de dados criado
            $this->conn = new mysqli($servername, $username, $password, $dbname);

            // Query para criar a tabela 'products' se não existir
            $sql = "CREATE TABLE IF NOT EXISTS `products` (
                `id` int(30) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `code` varchar(50) NOT NULL,
                `name` text NOT NULL,
                `description` text NOT NULL,
                `prev_price` float(12,2) NOT NULL DEFAULT 0.00,
                `current_price` float(12,2) NOT NULL DEFAULT 0.00,
                `img_path` text NOT NULL,
                `date_created` datetime NOT NULL DEFAULT current_timestamp(),
                `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
              );";

            // Executa a query de criação da tabela
            $this->conn->query($sql);

            // Verifica se houve erro na criação da tabela
            if ($this->conn->error) {
                echo "Error creating table: " . $this->conn->error;
            }

            // Insere produtos padrão se a tabela estiver vazia
            $check_db_data = $this->conn->query("SELECT `id` FROM `{$this->tablename}`")->num_rows;
            if ($check_db_data <= 0) {
                $insert_sql = "INSERT INTO `{$this->tablename}` (`code`, `name`, `description`, `prev_price`, `current_price`, `img_path`) VALUES
                            ('123456', 'The Last of Us Parte II', 'The Last of Us Part II é um jogo de ação e aventura que segue a história de Ellie em um mundo pós-apocalíptico.', 0, 145.23, 'upload/1.jpg'),
                            ('123457', 'Red Dead Redemption II', 'Red Dead Redemption II é um jogo de ação e aventura desenvolvido pela Rockstar Games. Ambientado no Velho Oeste, o jogo segue Arthur Morgan, um fora-da-lei e membro da gangue Van der Linde.', 520, 399, 'upload/2.jpg'),
                            ('123458', 'Spider-Man 2', 'Os Spiders Peter Parker e Miles Morales estão de volta em mais uma aventura eletrizante da famosa franquia Marvel Spider-Man. ', 0, 1299, 'upload/3.jpg'),
                            ('123459', 'Starfield', 'Starfield é um jogo de RPG de mundo aberto ambientado no espaço. ', 799, 599, 'upload/4.jpg'),
                            ('123450', 'Grand Theft Auto VI', 'Grand Theft Auto VI (GTA VI) é um jogo de ação e aventura desenvolvido pela Rockstar North e publicado pela Rockstar Games. O jogo se passa na fictícia cidade de Vice City, uma recriação satírica de Miami, e seus arredores. ', 1999, 1599, 'upload/5.jpg')";
                $this->conn->query($insert_sql);
            }
        } else {
            return false;
        }
    }

    // Método para obter dados dos produtos no banco de dados
    public function getData($pids = [])
    {
        $where = "";
        // Verifica se há IDs de produtos especificados
        if (count($pids)) {
            $pids = implode(",", $pids);
            $where = " WHERE id IN ({$pids})";
        }
        // Query para selecionar todos os dados da tabela 'products' com base nos IDs especificados
        $sql = "SELECT * FROM {$this->tablename} $where";

        // Executa a query e obtém o resultado
        $result = $this->conn->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            return $result;
        }
    }
}
?>

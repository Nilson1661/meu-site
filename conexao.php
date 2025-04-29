<?php
// Ativar a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Definir as credenciais de conexão
$host = 'localhost';  // Como você está usando o XAMPP, o host será geralmente 'localhost'
$usuario = 'pablo';   // O nome de usuário do banco de dados
$senha = '1234';     // A senha do banco de dados
$banco = 'ondearisada';  // O nome do banco de dados

// Criando a conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificando se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida ao banco de dados '$banco'!";
}
?>




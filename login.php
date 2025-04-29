<?php
// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de conexão
    include("conexao.php");

    // Recebe os dados do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar o usuário no banco
    $sql = "SELECT senha FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se encontrou o usuário
    if ($result->num_rows > 0) {
        // Recupera o hash da senha do banco de dados
        $row = $result->fetch_assoc();
        $senha_hash = $row['senha'];

        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $senha_hash)) {
            // Inicia a sessão e guarda o nome de usuário na sessão
            $_SESSION['usuario'] = $usuario;

            // Redireciona para a página principal do seu site (risada.html)
            header("Location: http://localhost/OndeaRisada%C3%A9Garantida/templates/ondearisada.html");
            exit();
        } else {
            echo "<p class='error'>Senha incorreta.</p>";
        }
    } else {
        echo "<p class='error'>Usuário não encontrado.</p>";
    }
}
?><!DOCTYPE html><html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(255, 255, 255);
            color: #333;
            margin: 0;
            padding: 0;
        }.container {
        max-width: 480px; /* Aumentado para simetria */
        margin: 100px auto;
        background-color: rgb(85, 0, 255);
        padding: 30px 50px; /* Ajustado para maior espaçamento lateral */
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    h2 {
        text-align: center;
        color: rgb(0, 0, 0);
        font-size: 24px;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin: 12px 0 6px;
        font-weight: bold;
        color: black;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0 20px 0;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: rgb(255, 255, 255);
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: rgb(0, 0, 0);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: rgb(0, 0, 0);
    }

    .error {
        color: #ff4d4d;
        font-size: 16px;
        text-align: center;
        margin-top: 20px;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
    }

    .register-link a {
        color: rgb(0, 0, 0);
        text-decoration: none;
        font-weight: bold;
    }

    .register-link a:hover {
        color: rgb(83, 10, 151);
    }
</style>

</head>
<body><div class="container">
    <h2>Login de Usuário</h2>

    <?php if (isset($erro)) { ?>
        <p class="error"><?php echo $erro; ?></p>
    <?php } ?>

    <form method="POST" action="login.php">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <div class="register-link">
        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</div>

</body>
</html>
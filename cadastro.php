<?php 
// Conecta ao banco de dados
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verifica se o usuário já existe no banco
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o usuário já existe, exibe mensagem de erro
        $erro = "Este usuário já está cadastrado. Tente outro.";
    } else {
        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo usuário no banco
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $senha_hash);

        if ($stmt->execute()) {
            // Redireciona para a página de login após cadastro
            header("Location: login.php");
            exit();
        } else {
            // Se ocorrer um erro na execução da query de inserção
            $erro = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novos Usuários</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(255, 255, 255);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 450px;
            margin: 100px auto;
            background-color:rgb(85, 0, 255);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            color:rgb(0, 0, 0);
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
            color: black; /* Mudando a cor para preto */
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
            border-color:rgb(255, 255, 255);
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color:rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color:rgb(0, 255, 38);
        }
        .error {
            color: #ff4d4d;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Cadastro de Novos Usuários</h2>
        
        <?php if (isset($erro)) { ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php } ?>

        <form method="POST" action="cadastro.php">
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

</body>
</html>
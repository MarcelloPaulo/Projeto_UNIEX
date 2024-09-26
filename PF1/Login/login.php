<?php
session_start(); // Inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IFRJ</title>
    <link rel="stylesheet" href="login-style.css"> <!-- CSS para a página de login -->
    <link rel="icon" href="../Assets/icon.svg" type="image/svg+xml">
</head>
<body>
    <header>
        <h1>Login - IFRJ</h1>
    </header>

    <main>
        <h2>Acesse sua conta</h2>

        <?php
        // Inicializa a mensagem de erro
        $mensagemErro = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conectar ao banco de dados
            $conn = mysqli_connect("localhost", "root", "", "alunos");

            // Verificar a conexão
            if (!$conn) {
                die("Conexão falhou: " . mysqli_connect_error());
            }

            // Obter os dados do formulário
            $matricula = $_POST['matricula'];
            $senha = $_POST['senha'];

            // Verificar se a matrícula e a senha estão corretas
            $sql = "SELECT * FROM alunos WHERE matricula = '$matricula' AND senha = '$senha'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Login bem-sucedido
                $_SESSION['loggedin'] = true; // Armazena que o usuário está logado
                echo "<script>
                        alert('LOGIN EFETUADO COM SUCESSO!');
                        window.location.href='../Principal/index.html'; // Redirecionar para a página principal
                      </script>";
                exit();
            } else {
                $mensagemErro = "MATRÍCULA OU SENHA INCORRETOS!";
            }

            // Fechar a conexão
            mysqli_close($conn);
        }
        ?>

        <form action="login.php" method="post">
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" id="matricula" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <input type="submit" value="Entrar">
            <input type="reset" value="Limpar">
        </form>

        <?php if (!empty($mensagemErro)): ?>
            <div class="error-message"><?php echo $mensagemErro; ?></div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; Uniforme Express - IFRJ</p>
    </footer>
</body>
</html>

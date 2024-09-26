<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos - IFRJ</title>
    <link rel="stylesheet" href="style.css"> <!-- CSS -->
    <link rel="icon" href="../Assets/icon.svg" type="image/svg+xml">
</head>
<body>
    <header>
        <h1>Cadastro de Alunos - IFRJ</h1>
    </header>

    <main>
        <h2>Cadastro de Aluno</h2>

        <?php
        // Inicializa as mensagens
        $mensagemSucesso = "";
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
            $nome = $_POST['nome'];
            $curso = $_POST['curso'];
            $senha = $_POST['senha'];

            // Verificar se a matrícula já existe
            $sql = "SELECT * FROM alunos WHERE matricula = '$matricula'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $mensagemErro = "JÁ EXISTE UM ALUNO COM A MESMA MATRÍCULA!";
            } else {
                // Inserir novo aluno
                $sql = "INSERT INTO alunos (matricula, nome, curso, senha) VALUES ('$matricula', '$nome', '$curso', '$senha')";
                if (mysqli_query($conn, $sql)) {
                    $mensagemSucesso = "ALUNO CADASTRADO COM SUCESSO!";
                } else {
                    $mensagemErro = "ERRO AO CADASTRAR ALUNO: " . mysqli_error($conn);
                }
            }

            // Fechar a conexão
            mysqli_close($conn);
        }
        ?>

        <form action="cadastro.php" method="post">
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" id="matricula" required>

            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="curso">Curso:</label>
            <input type="text" name="curso" id="curso" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <input type="submit" value="Cadastrar">
            <input type="reset" value="Limpar">
        </form>

        <?php if (!empty($mensagemErro)): ?>
            <div class="error-message"><?php echo $mensagemErro; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($mensagemSucesso)): ?>
            <div class="success-message"><?php echo $mensagemSucesso; ?></div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; Uniforme Express - IFRJ</p>
    </footer>
</body>
</html>

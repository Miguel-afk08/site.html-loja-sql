<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro.htm");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($nome === "" || $email === "" || $senha === "") {
    exit("Por favor, preencha todos os campos.");
}

// Criptografa a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Verifica se o e-mail já existe
$sql_check = "SELECT id FROM usuarios WHERE email = ?";
$stmt_check = $conexao->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$resultado = $stmt_check->get_result();

if ($resultado->num_rows > 0) {
    exit("Este e-mail já está cadastrado! <a href='cadastro.htm'>Tente outro</a>");
}

// Inserir no banco (Apenas nome, email e senha)
$sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt_insert = $conexao->prepare($sql_insert);
$stmt_insert->bind_param("sss", $nome, $email, $senha_hash);

if ($stmt_insert->execute()) {
    echo "<h2 style='color: green; text-align: center; font-family: Arial;'>✅ Conta criada com sucesso!</h2>";
    echo "<p style='text-align: center; font-family: Arial;'><a href='index.htm'>Clique aqui para fazer login</a></p>";
} else {
    echo "Erro ao cadastrar usuário: " . $conexao->error;
}

$stmt_insert->close();
$conexao->close();
?>

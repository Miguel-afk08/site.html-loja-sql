<?php
session_start();
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.htm");
    exit;
}

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($email === "" || $senha === "") {
    exit("Preencha o e-mail e a senha.");
}

$sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($sql);

if (!$stmt) {
    exit("Erro ao preparar a consulta: " . $conexao->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario && password_verify($senha, $usuario["senha"])) {
    $_SESSION["usuario"] = $usuario["nome"];
    header("Location: cardapio.htm");
    exit;
}

echo "E-mail ou senha incorretos. <a href='index.htm'>Tentar novamente</a>";
$stmt->close();
$conexao->close();
?>


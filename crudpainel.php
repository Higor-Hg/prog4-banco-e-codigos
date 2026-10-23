<?php
include '../../conectabanco.php';

// PROCESSA O FORMULÁRIO DE CADASTRO
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["acao"])) {

    $nome = $_POST["nome"] ?? "";
    $datainicio = $_POST["datainicio"] ?? "";
    $datafim = $_POST["datafim"] ?? "";

    if (!empty($nome)) {

        $sql = "INSERT INTO painelhigor (nome, datainicio, datafim)
                VALUES (:nome, :datainicio, :datafim)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":datainicio", $datainicio);
        $stmt->bindParam(":datafim", $datafim);

        $stmt->execute();

        // Redireciona para evitar reinclusão ao apertar F5
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=sucesso");
        exit();

    } else {
        echo "<p>Preencha todos os campos.</p>";
    }
}
?>

<html>

<link rel="stylesheet" href="stylehigor.css">

<!-- FORMULÁRIO -->
<div class="container">

    <form method="post" action="">

        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br><br>

        <label>Data Início:</label>
        <input type="datetime-local" name="datainicio" required>
        <br><br>

        <label>Data Fim:</label>
        <input type="datetime-local" name="datafim" required>
        <br><br>

        <button type="submit">Salvar</button>

    </form>

</div>


<div class="containerlista">

<h3>Painel de Led's RGB</h3>

<table border="1">

<tr>
</tr>

<?php

// DELETE
if (isset($_GET["delete"])) {

    $idpainel = $_GET["delete"];

    $sql = "DELETE FROM painelhigor
            WHERE idpainelhigor = :idpainel";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":idpainel", $idpainel);

    $stmt->execute();
}


// UPDATE
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["acao"]) &&
    $_POST["acao"] === "update"
) {

    $novoIdpainel = $_POST["novoIdpainel"];
    $novoNome = $_POST["novoNome"];
    $novoDatainicio = $_POST["novoDatainicio"];
    $novoDatafim = $_POST["novoDatafim"];


    $sql = "UPDATE painelhigor
            SET nome = :novoNome,
                datainicio = :novoDatainicio,
                datafim = :novoDatafim
            WHERE idpainelhigor = :idpainel";


    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":idpainel", $novoIdpainel);
    $stmt->bindParam(":novoNome", $novoNome);
    $stmt->bindParam(":novoDatainicio", $novoDatainicio);
    $stmt->bindParam(":novoDatafim", $novoDatafim);

    $stmt->execute();
}


// SELECT
$sql = "SELECT idpainelhigor, nome, datainicio, datafim
        FROM painelhigor";

$resultado = $conn->query($sql);


foreach ($resultado as $row) {

    echo "<tr>";

    echo "
    <td>

        <!-- FORMULÁRIO UPDATE -->

        <form method='post' action='' style='display:inline;'>

            <input type='hidden'
                   name='acao'
                   value='update'>

            <input type='hidden'
                   name='novoIdpainel'
                   value='{$row['idpainelhigor']}'>

            <label>
                Nome:
                <input type='text'
                       name='novoNome'
                       value='{$row['nome']}'>
            </label>

            <label>
                Data Início:
                <input type='datetime-local'
                       name='novoDatainicio'
                       value='{$row['datainicio']}'>
            </label>

            <label>
                Data Fim:
                <input type='datetime-local'
                       name='novoDatafim'
                       value='{$row['datafim']}'>
            </label>

            <button type='submit'>
                Atualizar
            </button>

        </form>


        <!-- DELETE -->

        <a href='?delete={$row['idpainelhigor']}'
           onclick=\"return confirm('Deseja excluir?')\">
            Excluir
        </a>

    </td>

    </tr>";
}

?>

</table>

</div>

</html>

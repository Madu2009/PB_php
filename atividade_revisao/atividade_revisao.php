<?php
session_start();
class Aluno {
    public $nome;
    public $sobrenome;
    public $nota;
    public $anoNascimento;

    public function __construct($nome, $sobrenome, $nota, $anoNascimento) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->nota = $nota;
        $this->anoNascimento = $anoNascimento;
    }

    public function calcularIdade($dataNascimento) {
       $dataNascimento=new DateTime($dataNascimento);
       $dataAtual=new DateTime();
       $idade= $dataNascimento-> diff($dataAtual);
       return $idade -> y;
    }

    public function salvar() {
        if (!isset($_SESSION['alunos'])) {
            $_SESSION['alunos'] = [];
        }
        $_SESSION['alunos'][] = $this;
    }
    public function calcularMedia(){
        $media = 0;
        $soma = 0;

    if (isset($_SESSION['alunos'])) {
        foreach ($_SESSION['alunos'] as $aluno) {
            $soma += $aluno->anoNascimento;
        }

    if (count($_SESSION['alunos']) > 0) {
        $media = $soma / count($_SESSION['alunos']);
    }
    return $media;
    }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['reset'])) {
        session_destroy();
    }

    if (isset($_POST['nome'])) {
        $aluno = new Aluno(
            $_POST['nome'],
            $_POST['sobrenome'],
            $_POST['nota'],
            $_POST['anoNascimento']
        );

        $aluno->salvar();
    }
}

  if(isset($_GET['reset'])){
    session_destroy();
  }
$media = 0;
$soma = 0;

if (isset($_SESSION['alunos'])) {
    foreach ($_SESSION['alunos'] as $aluno) {
        $soma += $aluno->anoNascimento;
    }

    if (count($_SESSION['alunos']) > 0) {
        $media = $soma / count($_SESSION['alunos']);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
</head>
<body>

<h2>Cadastro de Alunos</h2>

<form method="POST">
    Nome: <br>
    <input type="text" name="nome" value="" ><br><br>
    Sobrenome: <br>
    <input type="text" name="sobrenome" value="" ><br><br>
    Data Nascimento: <br>
    <input type="date" name="nota" value="" ><br><br>
    Nota: <br>
    <input type="number" name="anoNascimento" value="" ><br><br>

    <button type="submit">Cadastrar</button>
    <button type="submit" name="reset">Limpar</button>
</form>

<hr>

<table border="1">
    <tr>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Data Nascimento</th>
        <th>Idade</th>
        <th>nota</th>
    </tr>

    <?php if (isset($_SESSION['alunos'])): ?>
        <?php foreach ($_SESSION['alunos'] as $aluno): ?>
            <tr>
                <td><?= $aluno->nome ?></td>
                <td><?= $aluno->sobrenome ?></td>
                <td><?= $aluno->nota ?></td>
                <td><?= $aluno->calcularIdade($aluno->nota) ?> anos</td>
                <td><?= $aluno->anoNascimento ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php
$media = new Aluno('teste','teste','10','10','2000-10-10');
?>
<h3>Média das notas: <?= $media->calcularMedia() ?></h3>

</body>
</html>
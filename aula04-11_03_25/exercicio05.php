<?php 

$alunos = array(
    "Paulo" => 4,
    "Gabriel" => 5,
    "Bryan" => 7,
    "Kevyn" => 1
);


$totalNotas = 0;

foreach ($alunos as $aluno) {
    $totalNotas += $aluno;
}

$mediaNotas = $totalNotas / count($alunos);

echo $mediaNotas;
 
?>
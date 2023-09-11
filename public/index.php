<?php
require_once(__DIR__.'/../src/DiarioOficial.php');
require_once(__DIR__.'/../src/ConsultaDiario.php');

use ApiDoe\DiarioOficial;
use ApiDoe\ConsultaDiario;
header('Content-Type: application/json; charset=utf-8');    


$por = filter_input(INPUT_POST, 'por');
$texto = filter_input(INPUT_POST, 'texto');
$dataInicial = filter_input(INPUT_POST, 'data-inicial');
$dataFinal = filter_input(INPUT_POST, 'data-final');
$edicao = filter_input(INPUT_POST, 'edicao');
$tipoDocumento = filter_input(INPUT_POST, 'tipo-documento');
$numero = filter_input(INPUT_POST, 'numero');

// $dataInicial="2022-01-01";
// $dataFinal="2023-09-11";
$por = "texto";

$url = "https://diariooficial.to.gov.br/busca?por=";

$diario = new DiarioOficial();
$diario->setPor($por);
$diario->setTexto($texto);
$diario->setDataInicial($dataInicial);
$diario->setDataFinal($dataFinal);
$diario->setEdicao($edicao);
$diario->setTipoDocumento($tipoDocumento);
$diario->setNumero($numero);
$diario->setUrlBase($url);

$consulta = new ConsultaDiario($diario);
echo $consulta->makeObjectDOE();


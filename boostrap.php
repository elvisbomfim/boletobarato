<?php

// Inclua a classe BoletoAPI no seu arquivo de teste
require_once 'vendor/autoload.php';

use Econsulte\BoletoBarato\BoletoSDK;
use Econsulte\BoletoBarato\Boleto;
use Econsulte\BoletoBarato\Cliente;
use Econsulte\BoletoBarato\Config;
// Crie um novo objeto BoletoAPI com as credenciais de autenticação da API
$api = new BoletoSDK('################################');

$nome 			 = '';
$cpfcnpj 		 =  '';
$valor 			 =  '25,00';
$email 			 = '';
$celular 		 =  '';
$end_cep 		 =  '';
$end_uf 		 = '';
$end_cidade_nome = '';
$end_cidade_id 	 = '';
$end_bairro 	 = '';
$end_logradouro  = '';
$end_numero 	 = '';

$date = date('Y-m-d');




$cliente = new Cliente($nome, $cpfcnpj, $celular, $email, $end_logradouro, $end_numero, "", $end_bairro, $end_cep, $end_cidade_nome, $end_uf);

$parcelas = 3;


$day = 1;

$carne_id = 200;

for ($i = 1; $i <= $parcelas; $i++) {
	if ($i == 1) :
		$config = new Config("https://example.com/notification");

		$vencimento = date('d/m/Y', strtotime($date));
	else :
		$config = new Config("https://example.com/notification", 0);

		$vencimento = date('d/m/Y', strtotime($date . " +{$day} month"));

		$day++;

	endif;

	if ($parcelas > 1) :
		$result = $api->add((new Boleto($config, $cliente, "{$carne_id}", "19,90", $vencimento, "parc. " . $i . " de " . $parcelas, "Cobrança Aresta - parcela {$i} de {$parcelas}"))
			->setCarne(1)
			->setIdParcelamento($carne_id)
			->setNumParcela($i)
			->setIdParcela($carne_id + $i));
	else :
		$result = $api->add((new Boleto($config, $cliente, "123", "50,00", $vencimento, $carne_id, "Cobrança teste avulsa"))->setCarne(0));
	endif;
}


$result = $result->create();

var_dump($result);

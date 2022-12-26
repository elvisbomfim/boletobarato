# INSTALAÇÃO
```````
composer require econsulte/boleto_barato
```````

# INÍCIO
Crie um novo objeto BoletoSDK com as credenciais de autenticação da API
```````
use Econsulte\BoletoBarato\BoletoSDK;
$api = new BoletoSDK('################################');
```````

# CRIAÇÃO

```````
use Econsulte\BoletoBarato\Boleto;
use Econsulte\BoletoBarato\Cliente;
use Econsulte\BoletoBarato\Config;

$cliente = new Cliente($nome, $cpfcnpj, $celular, $email, $end_logradouro, $end_numero, "", $end_bairro, $end_cep, $end_cidade_nome, $end_uf);

$parcelas = 3; //quantidade de parcelas;


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

	if ($parcelas > 1) : /// condição caso tenha parcelas
		$result = $api->add((new Boleto($config, $cliente, "{$carne_id}", "19,90", $vencimento, "parc. " . $i . " de " . $parcelas, "Cobrança Aresta - parcela {$i} de {$parcelas}"))
			->setCarne(1)
			->setIdParcelamento($carne_id)
			->setNumParcela($i)
			->setIdParcela($carne_id + $i));
	else : // para criar boleto avulso
		$result = $api->add((new Boleto($config, $cliente, "123", "50,00", $vencimento, $carne_id, "Cobrança teste avulsa"))->setCarne(0));
	endif;
}


```````

# CANCELAMENTO

```````
$result = $api->cancel($codigo);
```````
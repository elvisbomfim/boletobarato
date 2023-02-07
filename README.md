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

# EMISSÂO DE BOLETO 

```````
use Econsulte\BoletoBarato\Boleto;
use Econsulte\BoletoBarato\Cliente;
use Econsulte\BoletoBarato\Config;

$cliente = new Cliente($nome, $cpfcnpj, $celular, $email, $end_logradouro, $end_numero, "", $end_bairro, $end_cep, $end_cidade_nome, $end_uf);

$parcelas = 3; //quantidade de parcelas;


$date = date("Y-m-d");

$day = 1;

$carne_id = 200;

for ($i = 1; $i <= $parcelas; $i++) {
	if ($i == 1) :
	   // configuração para retorno dos gatilhos de pagamento
		$config = new Config("https://example.com/notification");

		$vencimento = date('d/m/Y', strtotime($date));
	else :
	   // configuração para retorno dos gatilhos de pagamento
		$config = new Config("https://example.com/notification", 0); // 0 é para não enviar emails por default é 1 para enviar

		$vencimento = date('d/m/Y', strtotime($date . " +{$day} month"));

		$day++;

	endif;

	if ($parcelas > 1) : /// condição caso tenha parcelas
		$api->add((new Boleto($config, $cliente, "{$carne_id}", "19,90", $vencimento, "parc. " . $i . " de " . $parcelas, "Cobrança Aresta - parcela {$i} de {$parcelas}"))
			->setCarne(1) //se o formato do boleto vai ser carnê 1 para sim
			->setIdParcelamento($carne_id) // ID do Grupo 
			->setNumParcela($i) 
			->setIdParcela($carne_id + $i));
	else : // para criar boleto avulso
		$api->add((new Boleto($config, 
		$cliente, 
		"123", // codigo numerico de indentificação do boleto no seu sistema (geralmente PK)
		"50,00", //valor
		$vencimento, "d/m/Y"
		$carne_id, 
		"Cobrança teste avulsa"
		)
		)->setCarne(0));  se o formato do boleto vai ser carnê "0" para boleto avulso
	endif;
}

$resposta =  $api->create();

var_dump($resposta);


```````

# CANCELAMENTO

```````
$resposta = $api->cancel($boleto_id);
var_dump($resposta);
```````

# PESQUISA

```````
Pesquisa por ID do boleto ou pelo CPF ou CNPJ com mascara;
$resposta = $api->find($boleto_id, $cpf_cnpj);
var_dump($resposta);
```````

# NOTIFICAÇÃO
Esse código é para processar o retorno que o sistema traz quando o status de algum boleto é alterado,
lembrando que para haver retorno, na emissão do boleto deve ser informado na classe new Config("https://example.com/notification")
```````
Segue o código para desmembrar a resposta
 
public function notification(){

	$jd = $_POST;

	
	if($jd['tipo'] == 'boleto.status'){

		$jd = $jd['dados'];

		echo 'Status: '.$jd['status'].'<br>'; // 'pago', 'cancelado', 'pago parcialmente'

		echo 'Meu Código: '.$jd['meucodigo'].'<br>';

		echo 'idboleto: '. .$jd['idboleto'].'<br>';

		echo 'Valor Pago: '.$jd['valorpago'].'<br>';

		echo 'Data Pagamento: '.$jd['datapagamento'].'<br>';

	}else{

		echo 'Nenhum Status Identificado';

	}

}
```````
<?php 

	include "funcoesAuxiliares.php";
	
	$erro = '';
	
	if (isset($_GET['nome'])){
		
		// verificação de variáveis
		$nome 			 = $_GET['nome'];
		$cpfcnpj 		 = $_GET['cpfcnpj'];
		$valor 			 = $_GET['valor'];
		$email 			 = $_GET['email'];
		$celular 		 = $_GET['celular'];
		$end_cep 		 = $_GET['end_cep'];
		$end_uf 		 = $_GET['end_uf'];
		$end_cidade_nome = $_GET['end_cidade_nome'];
		$end_cidade_id 	 = $_GET['end_cidade_id'];
		$end_bairro 	 = $_GET['end_bairro'];
		$end_logradouro  = $_GET['end_logradouro'];
		$end_numero 	 = $_GET['end_numero'];  
		
		$valor_semmascara = @moeda_unmask($valor);	
		
		if 		($nome == ''){  $erro = "O campo Nome/Razão é obrigatório"; }
		else if ($cpfcnpj == ''){  $erro = "O campo Nome/Razão é obrigatório"; }
		else if ($valor == ''){  $erro = "O campo Valor é obrigatório"; } 
		else if ($valor_semmascara <= 5){  $erro = "O Valor deve ser maior que R$ 5,00"; }
		else if ($email == ''){  $erro = "O campo E-mail é obrigatório"; }
		else if ($celular == ''){  $erro = "O campo Celular é obrigatório"; }
		else if ($end_cep == ''){  $erro = "O campo Cep é obrigatório"; }
		else if ($end_uf == ''){  $erro = "O campo UF é obrigatório"; }
		else if ($end_cidade_id == ''){  $erro = "O campo Cidade é obrigatório"; }
		else if ($end_bairro == ''){  $erro = "O campo Bairro é obrigatório"; }
		else if ($end_logradouro == ''){  $erro = "O campo Logradouro é obrigatório"; }
		else if ($end_numero == ''){  $erro = "O campo Número é obrigatório"; }  
		
		// VERIFICA SE É CPF OU CNPJ VÁLIDO
		if( !valida_cpf($cpfcnpj) and !valida_cnpj($cpfcnpj) ){
			$erro = "CPF/CNPJ Inválido";
		}
		
		// Caso não tenha dado erro em nenhum dos campos
		if ($erro == ''){

			$dados["tipo"] = "boleto.remessa";

			$boleto = array();

			// configuração para retorno dos gatilhos de pagamento
			$boleto["config.urlretorno"] = "";

			// configurações de notificação
			$boleto["config.enviaemail"] = 0;
			$boleto["config.enviasms"] = 0;
			$boleto["config.recobrar"] = 0;

			$boleto["cliente.atualizadados"] = "0";	
			$boleto["cliente.nome"] = $nome;
			$boleto["cliente.cpfcnpj"] = $cpfcnpj;
			$boleto["cliente.celular"] = $celular;
			$boleto["cliente.email"] = $email;
			$boleto["cliente.fixo"] = "";		
			
			// dados de endereço
			$boleto["cliente.logradouro"] = $end_logradouro;
			$boleto["cliente.numero"] = $end_numero ;
			$boleto["cliente.complemento"] = "";
			$boleto["cliente.bairro"] = $end_bairro;
			$boleto["cliente.cep"] = $end_cep;
			$boleto["cliente.cidade"] = $end_cidade_id;
			$boleto["cliente.uf"] = $end_uf;

			// se o formato do boleto vai ser carnê
			$boleto["boleto.carne"] = "0";

			// codigo numerico de indentificação do boleto no seu sistema (geralmente PK)
			$boleto["boleto.meucodigo"] = '0000';

			// formato português mesmo
			$boleto["boleto.valor"] = "$valor";
			
			$hoje = date('Y-m-d');
			$vencimento = date('d/m/Y', strtotime($hoje . ' +1 day'));
			
			$boleto["boleto.datavencimento"] = $vencimento; //hoje
			$boleto["boleto.numerodoc"] = "";
			
			// Assunto/Título do E-mail
			$boleto["boleto.assunto"] = "";

			// 1 é porcentagem, 2 é valor fixo
			$boleto["boleto.tipmora"] = "2";
			$boleto["boleto.mora"] = "2,00";
			$boleto["boleto.tipmulta"] = "2";
			$boleto["boleto.multa"] = "1,00";


			// descritivo que vai na parte de cima do boleto
			$boleto["boleto.descritivo"] = "Contribuição Assistencial SJRP";

			// descritivo que vai na parte de baixo do boleto, para o caixa
			$boleto["boleto.corpoboleto"] = "";

			// especie do Boleto, a maioria é Duplicata Mercantil (DM)
			$boleto["boleto.especie"] = "DM";	

			// Adiciona Boleto ao lote de boletos
			$dados['dados'] = array();
			array_push($dados['dados'], $boleto);

			///////////////////////////////
			// Consome a API do Boleto ////
			///////////////////////////////
			$resposta = curl_boleto($dados);

			$coderroGeral = $resposta['coderro'];
			$erroGeral = $resposta['erro'];

			if($coderroGeral == 0){ // Nenhuma rejeição na authenticação ou padrão dos dados

				// LOOP PARA LER CADA BOLETO DO LOTE
				foreach ($resposta['dados'] as $k => $v) {				

					$meucodigo = @$v['meucodigo'];
					$status = @$v['status'];
					$coderro = $v['coderro'];
					$erro = $v['erro'];

					$urlboleto = @$v['urlboleto'];
					$urlfatura = @$v['urlfatura'];

					if($coderro == '0'){ // Não teve nenhuma rejeição
						echo "Redirecionando para o Boleto";
						header('Location: '.$urlboleto);
						exit;
					}else{
						$erro = "Ocorreu o seguinte erro: $erro (Cod. $coderro)";
					}

				}
			}else{
				$erro = "Ocorreu o seguinte erro: $erroGeral (Cod. $coderroGeral)";
			}
		
		}
		
		
	}	
	
	


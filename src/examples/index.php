<?php 

	/*
	 *  CÓDIGO DE INTEGRAÇÃO PARA A PLATAFORMA DE BOLETOS BOLETO BARATO
	 *  Versão: 2.2 
	 * 	
	 */
	 
	 include "integracaoBB.php";

?>
<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
	<script src="https://cobrancaporboleto.com.br/inc/js/jquery.maskMoney.js?3.0.0.21"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
</head>


	
	<?php if ($erro !=  ''){ ?>
		<div class="envioErro">
			<p class="pErro" style="background-color: rgb(255, 61, 0); padding: 4px; text-align: center; color: white;">
				<?php echo $erro; ?>
			</p>
		</div>
	<?php } ?>
	
	<form id="integracaoBB" action="./">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--6-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label fullwidth">
					<input class="mdl-textfield__input" type="text" id="nome" name="nome" value="<?php echo @$_GET['nome']; ?>">
					<label class="mdl-textfield__label" for="nome">Nome/Razão</label>
				</div>	
			</div>
			<div class="mdl-cell mdl-cell--4-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="cpfcnpj" name="cpfcnpj"  value="<?php echo @$_GET['cpfcnpj']; ?>">
					<label class="mdl-textfield__label" for="cpfcnpj">CPF/CNPJ</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--2-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="valor" name="valor" value="<?php echo @$_GET['valor']; ?>">
					<label class="mdl-textfield__label" for="valor">Valor</label>
				</div>
			</div>
		</div>
		
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--6-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="email" name="email" value="<?php echo @$_GET['email']; ?>">
					<label class="mdl-textfield__label" for="email">E-mail</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--3-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="celular" name="celular" maxlength=15 value="<?php echo @$_GET['celular']; ?>">
					<label class="mdl-textfield__label" for="celular">Celular/Fixo</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--2-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" id="end_cep" name="end_cep" maxlength=9>
					<label class="mdl-textfield__label" for="end_cep">CEP</label>					
				</div>
			</div>
			<div class="mdl-cell mdl-cell--1-col">
				<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised mdl-js-ripple-effect"
				id="buscarCEP" style="margin-top: 20px;">Buscar</button>
			</div>
			
		</div>
		
		<span class="controle_cep" >
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="end_uf" name="end_uf">
						<label class="mdl-textfield__label" for="end_uf">Estado</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--8-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="end_cidade_nome" name="end_cidade_nome">
						<input type="hidden" id="end_cidade_id" name="end_cidade_id">
						<label class="mdl-textfield__label" for="end_cidade_nome">Cidade</label>
					</div>
				</div>
			</div>
			
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="end_bairro" name="end_bairro">
						<label class="mdl-textfield__label" for="end_bairro">Bairro</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="end_logradouro" name="end_logradouro">
						<label class="mdl-textfield__label" for="end_logradouro">Logradouro/Endereço</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--2-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="end_numero" name="end_numero">
						<label class="mdl-textfield__label" for="end_numero">Número</label>
					</div>
				</div>
			</div>
		</span>
		

		<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect"
				style="float: right;">Gerar o Boleto</button>
	</form>

<script>
	
	$( document ).ready(function() {
		
		$("#cpfcnpj").inputmask({mask: ['999.999.999-99', '99.999.999/9999-99'], keepStatic: true });
		$("#end_cep").inputmask({mask: ['99999-999'], keepStatic: false });
		
		$(document).on('blur', '.mdl-textfield', function() {	
			var nodeList = document.querySelectorAll('.mdl-textfield');
			Array.prototype.forEach.call(nodeList, function (elem) {
				elem.MaterialTextfield.checkDirty();
			});
		});
		
		//Quando o campo cep perde o foco.
		$(document).on('click', '#buscarCEP', function(e) {	
			
			e.preventDefault();
			
			//Nova variável "cep" somente com dígitos.
			var cep = $("#end_cep").val().replace(/\D/g, '');

			//Verifica se campo cep possui valor informado.
			if (cep != "") {
				
				//Expressão regular para validar o CEP.
				var validacep = /^[0-9]{8}$/;

				//Valida o formato do CEP.
				if(validacep.test(cep)) {

					//Consulta o webservice viacep.com.br/
					$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

						if (!("erro" in dados)) {						
							//unload_novo();
							
							//Atualiza os campos com os valores da consulta.
							$("#end_logradouro").val(dados.logradouro);
							$("#end_bairro").val(dados.bairro);
							$("#end_complemento").val(dados.complemento);
							
							$("#end_cidade_id").val(dados.ibge);
							$("#end_cidade_nome").val(dados.localidade);
							
							$("#end_numero").focus();
							$("#end_numero").parent().addClass('is-dirty');
							
							$("#end_uf").val(dados.uf);
							
							$(".controle_cep").show();
							
							var nodeList = document.querySelectorAll('.mdl-textfield');
							Array.prototype.forEach.call(nodeList, function (elem) {
								elem.MaterialTextfield.checkDirty();
							});
							
						} //end if.
						else {
							$(".controle_cep").hide();
							//parent.newheight = $('#conteudo').height();
							//window.parent.autoResize('cadastro')
							$('.pErro').html("CEP não encontrado.");
						}
					});
				} //end if.
				else {
					//cep é inválido.
					$('.pErro').html('CEP Inválido')					
					$(".controle_cep").hide();
				}
			}
		});
		
		$("#valor").maskMoney({thousands:'.', decimal:',', symbolStay: true});
	
	});
	
	
	/* Máscaras ER */
	function mascara(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execmascara()",1)
	}
	function execmascara(){
		v_obj.value=v_fun(v_obj.value)
	}
	
	function mtel(v){
		v=v.replace(/\D/g,"");             		//Remove tudo o que não é dígito
		v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
		return v;
	}
	
	function id( el ){
		return document.getElementById( el );
	}	

	window.onload = function(){
		id('celular').onkeyup = function(){
			mascara( this, mtel );
		}
		
	}
</script>

<style>
	.mdl-textfield {
		width: 100%;
	}
	
	.mdl-textfield__label {
		color: rgba(0,0,0,.50);
	}
</style>

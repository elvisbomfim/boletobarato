<?php

namespace Econsulte\BoletoBarato;

use DateTime;
use Econsulte\BoletoBarato\Config;

class Boleto
{
    private $config;
    private $cliente;
    private $carne;
    private $idparcelamento;
    private $idparcela;
    private $numparcela;
    private $meucodigo;
    private $valor;
    private $datavencimento;
    private $numerodoc;
    private $assunto;
    private $tipmora;
    private $mora;
    private $tipmulta;
    private $multa;
    private $descritivo;
    private $corpoboleto;
    private $especie;
    private $carneCalled = false;


    public function __construct(
        Config $config,
        Cliente $cliente,

        $meucodigo,
        $valor,
        $datavencimento,
        string $numerodoc,
        string $assunto,
        $tipmora = "2",
        $mora = "2",
        string $tipmulta = "2",
        $multa = "1,00",
        string $descritivo = "",
        string $corpoboleto = "",
        string $especie = "DM"
    ) {

        $this->config = $config;
        $this->cliente = $cliente;




        $this->meucodigo = $meucodigo;
        $this->valor = $valor;
        $this->datavencimento = $datavencimento;
        $this->numerodoc = $numerodoc;
        $this->assunto = $assunto;
        $this->tipmora = $tipmora;
        $this->mora = $mora;
        $this->tipmulta = $tipmulta;
        $this->multa = $multa;
        $this->descritivo = $descritivo;
        $this->corpoboleto = $corpoboleto;
        $this->especie = $especie;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    public function getCarne()
    {
        return $this->carne;
    }

    public function setCarne(bool $carne)
    {
        $this->carneCalled = true;
        $this->carne = $carne;

        return $this;
    }

    public function getIdParcelamento()
    {
        return $this->idparcelamento;
    }

    public function setIdParcelamento(int $idparcelamento)
    {
        $this->idparcelamento = $idparcelamento;
        return $this;
    }

    public function getIdParcela()
    {
        return $this->idparcela;
    }

    public function setIdParcela($idparcela)
    {
        $this->idparcela = $idparcela;
        return $this;
    }

    public function getnumparcela()
    {
        return $this->numparcela;
    }

    public function setNumParcela($numparcela)
    {
        $this->numparcela = $numparcela;
        return $this;
    }

    public function getMeuCodigo()
    {
        return $this->meucodigo;
    }

    public function setMeuCodigo($meucodigo)
    {
        $this->meucodigo = $meucodigo;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getDataVencimento()
    {
        return $this->datavencimento;
    }

    public function setDataVencimento($datavencimento)
    {
        $this->datavencimento = $datavencimento;
    }

    public function getNumeroDoc()
    {
        return $this->numerodoc;
    }

    public function setNumeroDoc($numerodoc)
    {
        $this->numerodoc = $numerodoc;
        
    }

    public function getAssunto()
    {
        return $this->assunto;
    }

    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    public function getTipMora()
    {
        return $this->tipmora;
    }

    public function setTipMora($tipmora)
    {
        $this->tipmora = $tipmora;
    }

    public function getMora()
    {
        return $this->mora;
    }

    public function setMora($mora)
    {
        $this->mora = $mora;
    }

    public function getTipMulta()
    {
        return $this->tipmulta;
    }

    public function setTipMulta($tipmulta)
    {
        $this->tipmulta = $tipmulta;
    }

    public function getMulta()
    {
        return $this->multa;
    }

    public function setMulta($multa)
    {
        $this->multa = $multa;
    }

    public function getDescritivo()
    {
        return $this->descritivo;
    }

    public function setDescritivo($descritivo)
    {
        $this->descritivo = $descritivo;
    }

    public function getCorpoBoleto()
    {
        return $this->corpoboleto;
    }

    public function setCorpoBoleto($corpoboleto)
    {
        $this->corpoboleto = $corpoboleto;
    }

    public function getEspecie()
    {
        return $this->especie;
    }

    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    public function getInstrucoes()
    {
        return $this->instrucoes;
    }

    public function setInstrucoes($instrucoes)
    {
        $this->instrucoes = $instrucoes;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getNumeroDias()
    {
        return $this->numerodias;
    }

    public function setNumeroDias($numerodias)
    {
        $this->numerodias = $numerodias;
    }

    public function toArray()
    {

        if(!$this->carneCalled)
            throw new \Exception('chame o metodo setCarne(), e informe se formato do boleto: (1) para carnê e (0) para avulso');

        if ($this->carne == 1) {
            if (!$this->getIdParcelamento())
                throw new \Exception('informe o ID Parcelamento');

            if (!$this->getIdParcela())
                throw new \Exception('informe o ID Parcela');

            if (!$this->getnumparcela())
                throw new \Exception('informe o numparcela');
        }


        $config = array(
            "config.urlretorno" => $this->config->getUrlRetorno(),
            "config.enviaemail" => $this->config->getEnviaEmail(),
            "config.enviasms" => $this->config->getEnviaSms(),
            "config.recobrar" => $this->config->getRecobrar()
        );

        $cliente = array(
            "cliente.atualizadados" => $this->cliente->getAtualizaDados(),
            "cliente.nome" => $this->cliente->getNome(),
            "cliente.cpfcnpj" => $this->cliente->getCpfCnpj(),
            "cliente.celular" => $this->cliente->getCelular(),
            "cliente.email" => $this->cliente->getEmail(),
            "cliente.logradouro" => $this->cliente->getLogradouro(),
            'cliente.cidade' => $this->cliente->getCidade(),
            "cliente.uf" => $this->cliente->getUf()
        );

        $boleto = array(
            "boleto.carne" => $this->carne,
            "boleto.idparcelamento" => $this->idparcelamento,
            "boleto.idparcela" => $this->idparcela,
            "boleto.numparcela" => $this->numparcela,
            "boleto.meucodigo" => $this->meucodigo,
            "boleto.valor" => $this->valor,
            "boleto.datavencimento" => $this->datavencimento,
            "boleto.numerodoc" => $this->numerodoc,
            "boleto.assunto" => $this->assunto,
            "boleto.tipmora" => $this->tipmora,
            "boleto.mora" => $this->mora,
            "boleto.tipmulta" => $this->tipmulta,
            "boleto.multa" => $this->multa,
            "boleto.descritivo" => $this->descritivo,
            "boleto.corpoboleto" => $this->corpoboleto,
            "boleto.especie" => $this->especie,

        );

        //passar esses parâmetros somente se for formato carnê = 1
        if ($this->carne == 0) {
            unset($boleto["boleto.idparcelamento"]);
            unset($boleto["boleto.idparcela"]);
            unset($boleto["boleto.numparcela"]);
        }

        return array_merge($config, $cliente, $boleto);
    }
}

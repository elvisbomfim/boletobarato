<?php

namespace Econsulte\BoletoBarato;

use Econsulte\BoletoBarato\Validation;

class Cliente
{
    private $nome;
    private $cpfCnpj;
    private $celular;
    private $email;
    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $cep;
    private $cidade;
    private $uf;
    private $atualizaDados;

    public function __construct($nome, $cpfCnpj, $celular, $email,  $logradouro, $numero, $complemento, $bairro, $cep, $cidade, $uf, $atualizaDados = "0")
    {

        $this->setNome($nome);
        $this->setCpfCnpj($cpfCnpj);
        $this->setCelular($celular);
        $this->setEmail($email);
        $this->setLogradouro($logradouro);
        $this->setNumero($numero);
        $this->setComplemento($complemento);
        $this->setBairro($bairro);
        $this->setCep($cep);
        $this->setCidade($cidade);
        $this->setUf($uf);
        $this->atualizaDados = $atualizaDados;
    }



    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        if (!Validation::fullName($nome))
            throw new \Exception('Preencha nome e sobrenome');


        $this->nome = $nome;
    }

    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    public function setCpfCnpj($cpfCnpj)
    {

        $cpfCnpj = Validation::cpfCnpj($cpfCnpj);

        if (!$cpfCnpj)
            throw new \Exception('CPF/CNPJ Inválido');

           
        $this->cpfCnpj = $cpfCnpj;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        if (empty($celular))
            throw new \Exception('Preencha o celular');

        $this->celular = $celular;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (!Validation::email($email))
            throw new \Exception('email inválido');

        $this->email = $email;
    }


    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        if (empty($logradouro))
            throw new \Exception('Preencha o logradouro');

        $this->logradouro = $logradouro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        if (empty($numero))
            throw new \Exception('Preencha o numero');

        $this->numero = $numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        if (empty($bairro))
            throw new \Exception('Preencha o bairro');

        $this->bairro = $bairro;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function setUf($uf)
    {
        if (!Validation::uf($uf))
            throw new \Exception('uf inválido');

        $this->uf = $uf;
    }


    public function getUf()
    {
        return $this->uf;
    }

    public function getAtualizaDados()
    {
        return $this->atualizaDados;
    }

    public function setAtualizaDados($atualizaDados)
    {
        $this->atualizaDados = $atualizaDados;
    }
}

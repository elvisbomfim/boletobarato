<?php

namespace Econsulte\BoletoBarato;

class Config
{
    private $urlretorno;
    private $enviaemail;
    private $enviasms;
    private $recobrar;

    public function __construct(string $urlretorno, $enviaemail = 1, $enviasms = 0, $recobrar = 1)
    {
        $this->urlretorno = $urlretorno;
        $this->enviaemail = $enviaemail;
        $this->enviasms = $enviasms;
        $this->recobrar = $recobrar;
    }

    public function getUrlRetorno()
    {
        return $this->urlretorno;
    }

    public function setUrlRetorno($urlretorno)
    {
        $this->urlretorno = $urlretorno;
    }

    public function getEnviaEmail()
    {
        return $this->enviaemail;
    }

    public function setEnviaEmail($enviaemail)
    {
        $this->enviaemail = $enviaemail;
    }

    public function getEnviaSms()
    {
        return $this->enviasms;
    }

    public function setEnviaSms($enviasms)
    {
        $this->enviasms = $enviasms;
    }

    public function getRecobrar()
    {
        return $this->recobrar;
    }

    public function setRecobrar($recobrar)
    {
        $this->recobrar = $recobrar;
    }
}

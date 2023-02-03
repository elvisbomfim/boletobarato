<?php

namespace Econsulte\BoletoBarato;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Econsulte\BoletoBarato\Boleto;


class BoletoSDK
{
    // O URL da API de boleto
    private $apiUrl = 'https://cobrancaporboleto.com.br/api/v1/';

    // O token de acesso para autenticação
    private $accessToken;

    private $addCalled = false;

    // O cliente Guzzle
    private $client;

    private $dados = [
        'dados' => []
    ];

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client = new Client();
    }


    public function add(Boleto $boleto): BoletoSDK
    {
        array_push($this->dados['dados'], $boleto->toArray());
        $this->addCalled = true;

        return $this;
    }

    // Método para gerar um novo boleto
    public function create()
    {


        if (!$this->addCalled) {
            throw new \Exception("O método add() deve ser chamado antes do método create().");
        }


        $this->dados["tipo"] = "boleto.remessa";


        try {
            // Faça uma solicitação POST para a URL da API de boleto
            $response = $this->client->request('POST', $this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->accessToken . ":"),
                ],
                'form_params' => $this->dados
            ]);

            // Retorne o corpo da resposta como um objeto JSON
            return json_decode($response->getBody());
        } catch (ClientException $e) {
            // Trate qualquer exceção lançada pelo cliente aqui
            throw new \Exception($e->getMessage());
        }
    }

    // Método para cancelar um boleto
    public function cancel($boletoId)
    {
        try {
            // Faça uma solicitação POST para a URL da API de boleto
            $response = $this->client->request('POST', $this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->accessToken . ":"),
                ],
                'form_params' => [
                    'tipo' => "boleto.cancelar",
                    'idboleto' => $boletoId,
                ]
            ]);

            // Retorne o corpo da resposta como um objeto JSON
            return json_decode($response->getBody());
        } catch (ClientException $e) {
            // Trate qualquer exceção lançada pelo cliente aqui
            throw new \Exception($e->getMessage());
        }
    }

     // Método para cancelar um boleto
     public function find($boletoId, $vencimento)
     {

        $data_inicio = date("d/m/Y", strtotime($vencimento));
        $data_fim = date("d/m/Y", strtotime("+1 day", strtotime($vencimento)));

         try {
             // Faça uma solicitação POST para a URL da API de boleto
             $response = $this->client->request('POST', $this->apiUrl, [
                 'headers' => [
                     'Authorization' => 'Basic ' . base64_encode($this->accessToken . ":"),
                 ],
                 'form_params' => [
                     'tipo' => "boleto.retorno",
                     'data_tipo' => "0",
                     'data_inicio' =>  $data_inicio,
                     'data_fim' => $data_fim,
                     'idboleto' => $boletoId,                     
                 ]
             ]);
 
             // Retorne o corpo da resposta como um objeto JSON
             return json_decode($response->getBody());
         } catch (ClientException $e) {
             // Trate qualquer exceção lançada pelo cliente aqui
             throw new \Exception($e->getMessage());
         }
     }
}

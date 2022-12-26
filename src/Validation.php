<?php

namespace Econsulte\BoletoBarato;

class Validation
{



    public static function cpfCnpj($cpfcnpj)
    {
        // Remove caracteres especiais
        $cpfcnpj = preg_replace('/\D/', '', $cpfcnpj);


        // Verifica se é CPF
        if (strlen($cpfcnpj) === 11) {
            // Verifica se todos os dígitos são iguais
            if (preg_match('/(\d)\1{10}/', $cpfcnpj)) {
                return false;
            }

            // Calcula o primeiro dígito verificador
            $dv1 = 0;
            for ($i = 0; $i < 9; $i++) {
                $dv1 += $cpfcnpj[$i] * (10 - $i);
            }
            $dv1 = ($dv1 % 11) < 2 ? 0 : 11 - ($dv1 % 11);

            // Calcula o segundo dígito verificador
            $dv2 = 0;
            for ($i = 0; $i < 10; $i++) {
                $dv2 += $cpfcnpj[$i] * (11 - $i);
            }
            $dv2 = ($dv2 % 11) < 2 ? 0 : 11 - ($dv2 % 11);

            // Verifica se os dígitos verificadores são os mesmos informados
            if($dv1 === (int)$cpfcnpj[9] && $dv2 === (int)$cpfcnpj[10])
                return $cpfcnpj;
        }
        // Verifica se é CNPJ
        else if (strlen($cpfcnpj) === 14) {
            // Verifica se todos os dígitos são iguais
            if (preg_match('/(\d)\1{13}/', $cpfcnpj)) {
                return false;
            }

            // Calcula o primeiro dígito verificador
            $dv1 = 0;
            $weight = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            for ($i = 0; $i < 12; $i++) {
                $dv1 += $cpfcnpj[$i] * $weight[$i];
            }
            $dv1 = ($dv1 % 11) < 2 ? 0 : 11 - ($dv1 % 11);

            // Calcula o segundo dígito verificador
            $dv2 = 0;
            $weight = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            for ($i = 0; $i < 13; $i++) {
                $dv2 += $cpfcnpj[$i] * $weight[$i];
            }
            $dv2 = ($dv2 % 11) < 2 ? 0 : 11 - ($dv2 % 11);

            // Verifica se os dígitos verificadores são os mesmos informados
            if($dv1 === (int)$cpfcnpj[12] && $dv2  === (int)$cpfcnpj[13])
                return $cpfcnpj;
        }
        return false;
    }

    public static function fullName($nome)
    {
        $nome = explode(' ', $nome);
        return count($nome) >= 2;
    }


    public static function email($email)
    {
        // Verifica se o email é válido usando a função filter_var
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function cep($cep)
    {
        // Remove caracteres especiais
        $cep = preg_replace('/\D/', '', $cep);
        // Verifica se o CEP possui exatamente 8 dígitos
        return preg_match('/^\d{8}$/', $cep);
    }

    public static function uf($uf) {
        // Verifica se a UF possui exatamente 2 caracteres
        // Usando uma expressão regular para verificar se há apenas letras
        return preg_match('/^[A-Za-z]{2}$/', $uf);
      }
}

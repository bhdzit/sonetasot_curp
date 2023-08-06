<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Nette\Utils\DateTime;


class CurpValidationRule implements DataAwareRule, InvokableRule
{
    protected $data = [];
    protected $vocales = ["A", "E", "I", "O", "U"];

    public function __invoke($attribute, $value, $fail)
    {
        //Valida formato de curp
        if (!$this->esFomratoDeCurpValida($this->data['curp']))
            $fail('El formato de curp es invalido');

        //Se valida si la informacion coencide con el Curp   
        if (!($this->genrateCurp() == $this->data['curp']))
            $fail('Los Datos no coinciden, Verifica los datos');
    }

    //Valida si el formato De curp es valido
    function esFomratoDeCurpValida($curp): bool
    {
        $regex = "/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/";
        $validado = preg_match($regex, $curp);
        if ($validado == 1)
            return true;

        return false;


    }

    function genrateCurp(): string
    {
        $fecha = new DateTime($this->data["fecha_nacimiento"]);
        //Se 
        $curp = $this->getLetraInicial($this->data["apellido_p"]) . $this->getPrimeraVocal($this->data["apellido_p"]);
        //
        $curp = $curp . $this->getLetraInicial($this->data["apellido_m"]) . $this->getLetraInicial($this->data["nombre"]);
        //
        $curp = $curp . $fecha->format("y") . $fecha->format("m") . $fecha->format("d");
        //
        $curp = $curp . $this->data["sexo"];
        //
        $curp = $curp . $this->data["estado"];
        //
        $curp = $curp . $this->getPrimeraConsoate($this->data["apellido_p"]) . $this->getPrimeraConsoate($this->data["apellido_m"]) . $this->getPrimeraConsoate($this->data["nombre"]);

        $curp = $curp . ($fecha->format("Y") < 2000 ? '0' : 'A') . $this->digito_verificador($curp);

        return $curp;
    }

    public function getLetraInicial($str): string
    {
        return $str[0];
    }

    function getPrimeraVocal($str): string
    {

        for ($i = 0; $i < strlen($str); $i++) {
            if (in_array($str[$i], $this->vocales))
                return $str[$i];
        }
        return "";
    }
    function getPrimeraConsoate($str): string
    {
        for ($i = 1; $i < strlen($str); $i++) {
            if (!(in_array($str[$i], $this->vocales)))
                return $str[$i];
        }
        return "";
    }

    public function setData($data)
    {
        //Se transofrma todas las peticiones a Uppercase
        foreach ($data as $key => $value) {
            $this->data[$key] = strtoupper($value);
        }
        return $this;
    }

    /**
     * Calcula el dígito verificador.
     */
    function digito_verificador($curp)
    {
        $curp = preg_split('//u', $curp, -1, PREG_SPLIT_NO_EMPTY);
        $contador = 18;
        $count = 0;
        $valor = 0;
        $sumaria = 0;

        $verificadores = [
            '0' => 0,
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            'A' => 10,
            'B' => 11,
            'C' => 12,
            'D' => 13,
            'E' => 14,
            'F' => 15,
            'G' => 16,
            'H' => 17,
            'I' => 18,
            'J' => 19,
            'K' => 20,
            'L' => 21,
            'M' => 22,
            'N' => 23,
            'Ñ' => 24,
            'O' => 25,
            'P' => 26,
            'Q' => 27,
            'R' => 28,
            'S' => 29,
            'T' => 30,
            'U' => 31,
            'V' => 32,
            'W' => 33,
            'X' => 34,
            'Y' => 35,
            'Z' => 36
        ];

        for ($i = 0; $i < count($curp); $i++) {
            $posicion = $curp[$i];

            foreach ($verificadores as $key => $value) {
                if (utf8_encode($posicion) == utf8_encode($key)) {
                    $valor = ($value * $contador);
                }
            }

            $contador = $contador - 1;
            $sumaria = $sumaria + $valor;
        }

        # Sacar el residuo
        $num_ver = $sumaria % 10;

        # Devuelve el valor absoluto en caso de que sea negativo
        $num_ver = abs(10 - $num_ver);

        # En caso de que sea 10 el digito es 0
        if ($num_ver == 10) {
            $num_ver = 0;
        }

        return strval($num_ver);
    }

}
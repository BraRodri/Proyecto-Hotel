<?php

namespace App\Helper;

class Helper {

    public static function getEstado($data)
    {
        $array = self::getDataEstado();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoUser($data)
    {
        $array = self::getDataEstadoUser();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoTipoServicio($data)
    {
        $array = self::getDataTipoServicio();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getTiposDocumentos($data)
    {
        $array = self::getDataTiposDocumentos();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadosCuartos($data)
    {
        $array = self::getDataEstadosCuartos();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getTiposIngresos($data)
    {
        $array = self::getDataTiposIngresos();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getEstadoServicio($data)
    {
        $array = self::getDataEstadoServicios();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getHoraServicios($data)
    {
        $array = self::getDataHorasServicio();
        $retorno = $array[$data];
        return $retorno;
    }

    public static function getDataEstado()
    {
        $data = array(
            1 => "Activo",
            0 => "Inactivo"
        );
        return $data;
    }

    public static function getDataEstadoUser()
    {
        $data = array(
            1 => "Activo",
            0 => "Inactivo"
        );
        return $data;
    }

    public static function getDataTiposDocumentos()
    {
        $data = array(
            1 => "Cédula de Ciudadania",
            2 => "Cédula de Extranjeria",
            3 => 'Nit',
            4 => "Pasaporte"
        );
        return $data;
    }

    public static function getDataTipoServicio()
    {
        $data = array(
            1 => "Activo",
            0 => "Inactivo",
        );
        return $data;
    }

    public static function getDataEstadosCuartos()
    {
        $data = array(
            1 => "Disponible",
            2 => 'Ocupado',
            3 => "Inactivo"
        );
        return $data;
    }

    public static function getDataTiposIngresos()
    {
        $data = array(
            1 => "Moto",
            2 => 'Carro',
            3 => "Peatonal"
        );
        return $data;
    }

    public static function getDataEstadoServicios()
    {
        $data = array(
            1 => "Iniciado",
            2 => 'Finalizado'
        );
        return $data;
    }

    public static function getDataHorasServicio()
    {
        $data = array(
            1 => "2 Horas",
            2 => '4 Horas',
            3 => '6 Horas',
            4 => '8 Horas',
            5 => '10 Horas',
            6 => '12 Horas',
            7 => '1 Dia',
            8 => '2 Dias',
            8 => '5 Dias',
        );
        return $data;
    }

    public static function getColorEstado($data)
    {
        switch ($data) {
            case 0:
                $color = "danger";
                break;
            case 1:
                $color = "success";
                break;
        }
        return $color;
    }

    public static function getColorEstadoUser($data)
    {
        switch ($data) {
            case 0:
                $color = "danger";
                break;
            case 1:
                $color = "success";
                break;
        }
        return $color;
    }

    public static function getColorEstadoCliente($data)
    {
        switch ($data) {
            case 0:
                $color = "warning";
                break;
            case 1:
                $color = "success";
                break;
            case 2:
                $color = "dark";
                break;
        }
        return $color;
    }

    public static function getColorEstadosCuartos($data)
    {
        switch ($data) {
            case 1:
                $color = "success";
                break;
            case 2:
                $color = "danger";
                break;
            case 3:
                $color = "dark";
                break;
        }
        return $color;
    }

    public static function getColorEstadoServicio($data)
    {
        switch ($data) {
            case 2:
                $color = "dark";
                break;
            case 1:
                $color = "success";
                break;
        }
        return $color;
    }

}

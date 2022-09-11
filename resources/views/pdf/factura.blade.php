<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Factura</title>

        <style>
            .table {
                width: 100%;
                max-width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .contenedor-principal{
                margin-top: 5px;
                width: 100%;
                padding: 20px;
            }

            .border_abajo{
                border-bottom: 1px solid #000;
                margin-right: 15px;
            }

            .margin-abajo{
                margin-bottom: 0px;
            }

            .texto-centrado{
                text-align: center !important;
            }

            .table-bordered {
                border: 1px solid;
                border-radius: 10px;
                border-collapse: collapse;
                font-size: 15px;
            }

            .table-bordered>:not(caption)>* {
                border-width: 1px 0;
            }

            .table-bordered>:not(caption)>*>* {
                border-width: 0 1px;
            }

            .table>:not(caption)>*>* {
                padding: 0.5rem 0.5rem;
                border-bottom-width: 1px;
            }

            .table-bordered tbody td {
                border-color: inherit;
                border-style: solid;
                border-width: 0;
                border: 1px solid;
                padding: 3px;
            }

            .table-bordered thead th {
                border-color: inherit;
                border-style: solid;
                border-width: 0;
                border: 1px solid #000;
                padding: 3px;
                color: #fff;
                background-color: #004F9F;
            }
        </style>

    </head>

    <body>

        <table class="table">
            <tbody>
                <tr>
                    <td width="50%">
                        <img src="images/LogoMotel.png" style="width: 80%;">
                    </td>
                    <td width="50%" style="text-align: center;">
                        <h2 style="margin-bottom: 20px;">
                            FACTURA
                        </h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr>
                    <td width="60%" style="padding-top: 10px;">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="20%" style="padding-bottom: 5px;">Fecha:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ date("Y-m-d h:i:s a", strtotime($factura->created_at)) }}
                                        </div>
                                    </td>
                                </tr>
                                <tr style="padding-top: 20px;">
                                    <td width="20%" style="padding-bottom: 5px;">Cuarto:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ $factura->cuarto }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="25%" style="padding-bottom: 5px;">Tipo Ingreso:</td>
                                    <td width="25%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ $factura->tipo_ingreso }}
                                        </div>
                                    </td>
                                    <td width="25%" style="padding-bottom: 5px;">Hrs Servicio:</td>
                                    <td width="25%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ $factura->horas_servicio }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="20%" style="padding-bottom: 5px;">Hora Ingreso:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ $factura->hora_ingreso }}
                                        </div>
                                    </td>
                                </tr>
                                <tr style="padding-top: 20px;">
                                    <td width="20%" style="padding-bottom: 5px;">ora Salida:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ $factura->hora_salida }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                    <td width="40%">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        RECIBO DE CAJA
                                    </td>
                                    <td width="70%">
                                        <div style="border: 1px solid; border-radius: 5px; text-align: center;">
                                            <h2 style="color: red;">
                                                N° {{ substr(str_repeat(0, 5).$factura->id, - 5) }}
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="65%">DETALLE</th>
                    <th width="35%">VALOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">
                        SERVICIO
                    </td>
                    <td style="text-align: center;">
                        {{ number_format($factura->precio, 0, ",", ".") }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        SUBTOTAL $
                    </td>
                    <td style="text-align: center;">
                        {{ number_format($factura->precio, 0, ",", ".") }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="table">
            <tbody>
                <tr>
                    <td width="60%">
                        <div style="border: 1px solid; border-radius: 10px; margin-right: 10px; padding: 10px; text-align: center;">
                            <div style="border-bottom: 1px solid; margin-top: 40px; margin-left: 40px; margin-right: 40px;"></div>
                            Firma y Sello
                        </div>
                    </td>
                    <td width="40%" style="text-align: center;">
                        TOTAL <br>
                        <div style="border: 1px solid; border-radius: 10px; padding: 15px; margin-top: 5px;">
                            {{ number_format($factura->precio, 0, ",", ".") }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>


    </body>

</html>

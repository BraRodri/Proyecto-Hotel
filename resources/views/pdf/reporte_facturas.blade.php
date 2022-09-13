<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reporte</title>

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
                            REPORTE FACTURAS
                        </h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="">#</th>
                    <th width="">Cuarto</th>
                    <th width="">Tipo Ingreso</th>
                    <th width="">Placa Vehiculo</th>
                    <th width="">Horas Servicio</th>
                    <th width="">Fecha Ingreso</th>
                    <th width="">Fecha Salida</th>
                    <th width="">Pago</th>
                    <th width="">Precio</th>
                    <th>Fecha Creacion</th>
                </tr>
            </thead>
            <tbody>
                @if (count($datos) > 0)
                    @foreach ($datos as $item)
                        <tr>
                            <td style="text-align: center;">
                                {{ $item->id }}
                            </td>
                            <td style="text-align: center;">
                                {{ ($item->cuarto) ? $item->cuarto : '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->tipo_ingreso }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->placa_vehiculo }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->horas_servicio }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->hora_ingreso }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->hora_salida }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->tipo_pago }}
                            </td>
                            <td style="text-align: center;">
                                {{ $item->precio }}
                            </td>
                            <td style="text-align: center;">
                                {{ date("Y-m-d h:i:s a", strtotime($item->created_at)) }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </body>

</html>

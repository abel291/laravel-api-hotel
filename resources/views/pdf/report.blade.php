<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ ltrim(public_path('css/front.css'), '/') }}" />
    <link rel="stylesheet" href="/css/front.css" />
    <title>Invoice #{{$reservation->order}}</title>
</head>

<body class="container">
    <div class="py-4">
        <div class="text-2xl font-bold text-gray-700 leading-none">
            Hotel <br> Cartagena
        </div>

    </div>
    <table class="text-sm text-gray-700">
        <tr valign="top">
            <td class="pr-4">
                <div class="mt-4">
                    <div class="font-bold">Invitado: </div>
                    <span>{{$client->name}}</span>
                </div>
                <div class="mt-4">
                    <div class="font-bold">Fehcha de entrada</div>
                    <span>{{$reservation->start_date->format('Y-m-d')}}</span>
                </div>
                <div class="mt-4">
                    <div class="font-bold">Fecha de salida</div>
                    <span>{{$reservation->end_date->format('Y-m-d')}}</span>
                </div>
            </td>

            <td class="pr-4">
                <div class="mt-4">
                    <div class="font-bold">Habitacion: </div>
                    <span>{{$reservation->night}}</span>
                </div>
                <div class="mt-4">
                    <div class="font-bold">Noches: </div>
                    <span>{{$reservation->night}}</span>
                </div>
                <div class="mt-4">
                    <div class="font-bold">Hora de llegada: </div>
                    <span>{{$reservation->check_in}}</span>
                </div>
            </td>
        </tr>
    </table>


 

        <table class="min-w-full text-gray-700 text-sm mt-5">

            <tr class="font-bold uppercase">
                <td class="py-2">Producto</td>
                <td class="py-2">Precio</td>
                <td class="py-2">Habitaciones</td>
                <td class="py-2">Total</td>
            </tr>


            <tr class="border-b border-gray-200 text-sm">

                <td class="py-2 pr-2 capitalize">
                    {{$reservation->room_reservation->name}}
                </td>

                <td class="pr-2 ">
                    {{Helpers::format_price($reservation->room_reservation->price_per_total_night)}}
                </td>

                <td class="pr-2 text-center">
                    {{$reservation->room_quantity}}
                </td>

                <td class="pr-2">
                    {{Helpers::format_price($reservation->room_reservation->price_per_reservation)}}
                </td>
            </tr>
            @if ($reservation->room_reservation->complements_cheked)
            @foreach ($reservation->room_reservation->complements_cheked as $complement)
            <tr class="">
                <td class="py-2 pr-2 pl-4">
                    {{$complement->name}}
                </td>

                <td class="pr-2">
                    {{Helpers::format_price($complement->price_per_total_night)}}
                </td>

                <td class="pr-2 text-center">
                    {{$reservation->room_quantity}}
                </td>

                <td class="pr-2">
                    {{Helpers::format_price($complement->total_price)}}
                </td>
            </tr>
            @endforeach
            @endif



            <tr class="font-bold">
                <td colspan="3" class="py-2 pr-4 text-right">
                    SUB-TOTAL
                </td>
                <td class="">
                    {{Helpers::format_price($reservation->sub_total_price)}}
                </td>

            </tr>

            @if ($reservation->discount_reservation)
            <tr class="font-bold">
                <td colspan="3" class="py-2 pr-4 text-right ">
                    <span>CUPON DE DESCUENTO</span>
                </td>
                <td class="text-green-500 ">
                    {{Helpers::format_price(-$reservation->discount_reservation->amount)}}
                </td>

            </tr>
            @endif

            <tr class="font-bold text-base">
                <td colspan="3" class="py-2 pr-4 text-right">
                    TOTAL
                </td>
                <td class="">
                    {{Helpers::format_price($reservation->total_price)}}
                </td>
            </tr>

        </table>


</body>

</html>
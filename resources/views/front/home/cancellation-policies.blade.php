@extends('front.layouts.app',[
    
    'nav_type'   =>'white',
    'banner_type'   =>false,
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>'/storage/pages/'.$page->img,
])

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('content')

<div class="container mx-auto max-w-screen-xl section-p-y ">

    <h3 class="text-4xl text-gray-700 font-bold mb-8">
        Cargos por cancelación de hoteles
    </h3>

    <div class="space-y-4 text-gray-600 leading-relaxed">
        <p>De manera general, la política de cancelación de hoteles aplica de la siguiente manera:</p>
        <ul class="list-disc ml-6">
            <li>Cancelaciones hechas 15 días o más antes de la fecha de llegada aplica un cargo de 10%.</li>

            <li> hechas de 3 a 14 días antes de la fecha de llegada aplica un cargo de 2 noches.</li>

            <li> hechas de 0 a 2 días antes de la fecha de llegada aplica un cargo de 100%.</li>
            <li>Si la habitación está marcada como no cancelable, no reembolsable o similar, aplica una penalidad
                del 100%
                sin importar la fecha en que solicita la cancelación.</li>
        </ul>


        <p>Las políticas de cancelación pueden variar dependiendo del hotel, época del año o tipo de habitación.
            Puedes
            revisar la política específica que aplica al hotel seleccionado durante el proceso de reservación.</p>

        <h3 class="text-2xl text-gray-700 font-bold">Cancelaciones en temporada alta y días festivos</h3>

        <p class="text-sm text-gray-400">Navidad, Año Nuevo, Semana Santa, verano, días feriados y fechas designadas
            por los hoteles.</p>
        <ul class="list-disc ml-6">
            <li> reservaciones canceladas 30 días o más antes de la fecha de llegada tienen un cargo del 10%</li>
            <li> reservaciones canceladas de 15 a 29 días antes de la fecha de llegada, tienen un cargo de 2 noches
            </li>
            <li> reservaciones canceladas con menos de 15 días de anticipación tienen un cargo del 100%</li>
        </ul>
        <p>En caso de que tengas que irte del hotel antes de que termine tu estancia (salida anticipada), o no te
            presentes al hotel (conocido como no show) se considera como cancelación y no aplican reembolsos. Si
            reduces
            el número de huéspedes una vez pagada la reservación, es decisión del hotel aplicar penalidades o
            reembolsos.</p>



        <div class="space-y-1">
            <h3 class="font-bold">Para cancelar llamar al:</h3>
            <div>01 8000-18880:</div>
            <div>y tener a la mano estos datos :</div>
            <ul class="list-disc ml-6 ">
                <li> Nombre completo de la persona que viaja</li>
                <li> Localizador</li>
                <li> Clave de confirmación (si ya la recibiste)</li>
            </ul>
        </div>

        <div class="space-y-1">
            <h3 class="font-bold">Horario de atención:</h3>
            <ul>
                <li>6:00 a.m. a 11:59 p.m de Lunes a Domingo</li>
            </ul>
        </div>

        <p>Si es preferible, favor de mandar la solicitud de cancelación vía email a contactenosco@pricetravel.co
            con
            los datos mencionados arriba.</p>

        <p>La solicitud será procesada y, si cumple con las políticas de cancelación del servicio reservado, se
            reembolsá la cantidad correspondiente a su tarjeta de crédito.</p>

    </div>
</div>

@endsection
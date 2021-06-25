Hola {{$reservation->client->name}},

¡Tu estancia se acerca !Aquí tienes algunos detalles para hacer tu visita más placentera:  

Reserva: #{{$reservation->order}}

Guest name: {{$reservation->client->name}}

Number of nights: {{$reservation->days}}

Fecha de llegada: {{$reservation->start_date->format('Y-m-d') }}

Fecha de salida: {{$reservation->end_date->format('Y-m-d')}} 

Hora de llegada: {{$reservation->check_in}}

Comienza tu estancia en [hotel name]

Si nos necesitas, contáctanos en [hotel phone] o [hotel email]

¡Nos vemos pronto!

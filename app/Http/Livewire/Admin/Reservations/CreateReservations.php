<?php


namespace App\Http\Livewire\Admin\Reservations;

use Livewire\Component;
use App\Models\Room;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Faker as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;
use Illuminate\Support\Str;

class CreateReservations extends Component
{
    public $reservation_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $step = 1;
    public Reservation $reservation;
    public Client $client;

    //paso-1 elegir fechas

    public $adults = 1;
    //public $kids = 0;

    //paso-2 elegir habitacion;     
    //public $rooms_quantity_availables;
    public $room_selected;
    public $rooms_quantity = [];
    //public $room_quantity_selected;
    //public $rooms;
    public $id_room;

    //paso-3 elegir experiencias
    //public $id_experieces;
    public $experiences_availables;
    public $experience_selected ;

    //paso 4 usuario
    public $email;
    public $email_confirmation;

    //cacnelar reservacion
    public $refund = false;


    protected $rules = [

        'reservation.start_date' => '',
        'reservation.end_date' => '',
        'reservation.days' => 'numeric',
        'reservation.total_price' => 'numeric',
        'reservation.room_quantity' => 'numeric',
        'reservation.special_request' => 'string|max:1000',
        'reservation.check_in' => 'required|string|max:20',

        'client.name' => 'required|string|max:255',
        'client.phone' => 'required|string|max:255',
        'client.country' => 'required|string|max:255',
        'client.city' => 'required|string|max:255',
        'client.email' => 'required|string|max:255',
        'email' => 'required|email|max:255|confirmed',        
        /*'room_quantity',
        'room_quantity_selected',
        'room_total_price_night',       
        'room_selectd.quantity_availables',        
        'room_selectd.total_price_night', */

    ];
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function mount()
    {
        $this->reset(
            'room_selected',
            'rooms_quantity',
            'id_room',            
            'experiences_availables',
            'experience_selected',
            'email',
            'email_confirmation',
            'adults'
        );

        $this->reservation = new Reservation;

        $this->client = new Client();
        $this->reservation->start_date = Carbon::now();
        $this->reservation->end_date = Carbon::now()->addDay();
    }
    public function create()
    {
        $this->open = true;

        $this->mount();
        $this->resetErrorBag();
        $this->step = 1;
    }
    public function check_1_date()
    {

        $this->validate([
            'reservation.start_date' => 'required|date|before:reservation.end_date',
            'reservation.end_date' => 'required|date|after:reservation.start_date',
            'adults' => 'required|min:1',
        ]);

        $this->reservation->days = $this->reservation->start_date->diffInDays($this->reservation->end_date);
        
        $this->step = 2;
        
        foreach ($this->rooms as $key => $room) {

            $this->rooms_quantity[$room->id] = "1";
        }
        
    }
    public function check_2_room($id_room = null)
    {

        $this->id_room = $id_room;

        $room = $this->rooms->firstWhere('id', $id_room);

        if ($room) {
            
            $this->reservation->room_quantity = (int)$this->rooms_quantity[$id_room];

            if ($room->experiences->isNotEmpty()) { //no esta vacio

                $this->experiences_availables = $room->experiences;

                $this->step = 3;
                foreach ($this->experiences_availables as $key => $value) {
                    
                    $value->total_price_curr = '$'. number_format($value->price * $this->reservation->days);
                
                }

            } else {

                $this->reset('experience_selected','experiences_availables');

                $this->step = 4;

            }
        } else {
            $this->check_1_date();
        }

        $faker = Faker\Factory::create();
        $this->client->name = $faker->name;
        $this->client->phone = $faker->phoneNumber;
        $this->email = $faker->safeEmail;
        $this->client->country = $faker->country;
        $this->client->city = $faker->city;
        $this->reservation->special_request = $faker->text($maxNbChars = 200);
    }
    public function check_3_experience($id_experiencie = null)
    {

        if ($id_experiencie) {
            $this->experience_selected = $this->experiences_availables->firstWhere('id', $id_experiencie);
        }
        
       

        $this->step = 4;
    }
    public function check_4_user()
    {
        
        $this->client->email = $this->email;

        $this->room_selected = $this->rooms->firstWhere('id', $this->id_room);
        
        $experience = $this->experience_selected;
        

        if ($experience) {

            $experience->total_price = $experience->price;

            if ($experience->type_price == 'nigth') {

                $experience->total_price = $experience->price * $this->reservation->days;
            }
            $experience->total_price_curr='$'.number_format($experience->total_price);

        }

        $price_room_experiencie = $this->room_selected->total_price_night + $experience->total_price;

        $this->reservation->total_price = $price_room_experiencie * $this->reservation->room_quantity;
        
        $this->step = 5;
    }
    public function check_5_confirmation($methodpayment)
    {

        DB::beginTransaction();

        $client = $this->client;
        $reservation = $this->reservation;
        $description_stripe = $client->name . " - " . $this->room_selected->name . " - " . $reservation->days . ' dias';

        try {

            $payment = $client->charge($this->reservation->total_price * 100, $methodpayment, [
                'description' => $description_stripe
            ]);
        } catch (\Stripe\Exception\CardException $e) {

            $this->addError('card', 'Por alguna razon no se puede cargar esta targeta');
            DB::rollback();
            return true;
        } catch (\Exception $e) {

            $this->addError('card', 'Hubo un error en la pasarela de pago por favor intente mas tarde');
            DB::rollback();
            return true;
        }


        $client->stripe_id = $payment->id;
        $client->save();
        $reservation->client()->associate($client->id);

        $reservation->room()->associate($this->room_selected->id);
        $reservation->room_reservation = $this->room_selected->only(['name', 'beds', 'adults', 'price']);

        if ($this->experience_selected) {

            $reservation->experience()->associate($this->experience_selected->id);
            $reservation->experience_reservation = $this->experience_selected->only(['name', 'price', 'type_price']);
        }

        $reservation->order = rand(1, 9) . $reservation->start_date->format('md') . $client->id;
        $reservation->save();

        DB::commit();

        Mail::to($client->email)->queue(new ReservationOrder($reservation,'order'));

        $this->mount();
        $this->open = false;
        $this->edit_var = false;
        $this->open_modal_confirmation = false;
        $this->emit('resetListReservations');

        $this->step = 1;
        $this->dispatchBrowserEvent('notification', [
            'title' => "Reservation Creada",
            'subtitle' => "Se enviara una notification al correo : $client->email"
        ]);
    }
    public function btn_back($step_back)
    {
        //$this->resetErrorBag();
        if ($step_back == 1) {

            $this->step = 1;
        } elseif ($step_back == 2) { //regresar a las habitaciones 

            $this->step = 2;
        } elseif ($step_back == 3) {

            if ($this->experiences_availables) {

                $this->step = 3;

            } else {

                $this->step = 2;
            }
        } elseif ($step_back == 4) {
            $this->step = 4;
        }
    }

    public function getRoomsProperty()
    {
        $start_date = $this->reservation->start_date;
        $end_date = $this->reservation->end_date;
        $days = $this->reservation->days;
        $rooms = Room::where('active', 1)
            ->where('adults', '>=', $this->adults)
            ->with(['reservations' => function ($query)  use ($start_date, $end_date) {

                $query->where('state', 'successful');

                $query->where(function ($q) use ($start_date, $end_date) {

                    $q->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date]);
                });
                $query->orWhere(function ($q) use ($start_date, $end_date) {

                    $q->where('start_date', '<=', $start_date)
                        ->where('end_date', '>=', $end_date);
                });
            }])
            ->with(['experiences' => function ($query) {
                $query->where('active', 1);
            }])->get()

            ->filter(function ($value, $key) {

                return $value->quantity > $value->reservations->sum('room_quantity');
            })
            ->transform(function ($value, $key) {

                $value->quantity_availables = $value->quantity - $value->reservations->sum('room_quantity');

                $value->total_price_night = $value->price * $this->reservation->days;

                return $value;
            });

        return $rooms;
    }

    
    public function cancel_reservation(Reservation $reservation)
    {
        //'canceled','refunded','successful'
        
        if ($reservation->state =='successful') {         
        
            $reservation->state = 'canceled';
            $reservation->canceled_date = Carbon::now();
            
            if ($this->refund) {
                $reservation->state = 'refunded';
                try {

                    $reservation->client->refund($reservation->client->stripe_id);
                } catch (\Exception $e) {

                    $this->addError('refund', $e->getMessage());
                    return true;
                }
            }

            $reservation->save();           
            Mail::to($reservation->client->email)->queue(new ReservationOrder($reservation,'canceled'));
            
            $this->reset('refund','open_modal_confirmation');
            $this->emit('resetListReservations');
            
            $this->dispatchBrowserEvent('notification', [
                'title' => "Reservation Cancelada",
                'subtitle' => "Se enviara una notification al correo a : ". $reservation->client->email ." con todo los detalles"
            ]);
        }else{
            $this->open_modal_confirmation = false;
            $this->dispatchBrowserEvent('notification', [
                'title' => "Reservation Cancelada",
                'subtitle' => "Esta reserva ya ha sido cancelada"
            ]);
        }
        
    }


    public function render()
    {
        return view('livewire.admin.reservations.create-reservations');
    }
}

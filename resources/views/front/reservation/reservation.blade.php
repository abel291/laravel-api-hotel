@extends('front.layouts.app')

@section('seo_title', 'Reservation')

@section('seo_desc', '')

@section('seo_keys', '')

@section('content')

<div class="text-gray-700 border-b border-gray-200 ">
    @include('front.navbar')
</div>

<div class="container mx-auto max-w-screen-xl section-p-y relative min-h-screen flex items-center justify-center">

    
    <div x-data="reservation_step" class="w-full">
        
        <div class="max-w-xl mx-auto text-red-500 rounded-lg py-4">
            <div class="" x-show="errors.default">
                <span class="block font-bold text-xl" x-text="errors.default"></span>
            </div>
        </div>

        <div x-show="step==1">
            @include('front.reservation.step_1_date')
        </div>

        <div x-show="step==2">
            @include('front.reservation.step_2_rooms')
        </div>

        <div x-show="step==3">
            @include('front.reservation.step_3_complements')
        </div>

        <div x-show="step==4">
            @include('front.reservation.step_4_user')
        </div>

        <div x-show="step==5">
            @include('front.reservation.step_5_order_details')
        </div>


    </div>
</div>
<script defer>
    document.addEventListener('alpine:init', () => {
                    Alpine.data('reservation_step', () => ({
                        step: 1,
                        night: 0,
                        start_date: '',
                        end_date: '',
                        adults:1 ,
                        kids:0,
                        room_quantity: '',
                        
                        complements: [],
                        ids_complements_cheked: [], 
                        complements_cheked: [],//solo para el paso final
                        rooms:[],
                        room_selected: {},
                        
                        total_price: 0,
                        price_per_reservation: 0,
                        isLoading:false,

                        client_name:'{{$client->name}}',
                        client_phone:'{{$client->phone}}',
                        client_email:'{{$client->email}}',
                        client_email_confirmation:'{{$client->email}}',
                        client_country:'{{$client->country}}',
                        client_city:'{{$client->city}}',
                        client_check_in:'',
                        client_special_request:'{{$client->special_request}}',

                        
                        errors:[],

                        //stripe

                        stripe_key:'',
                        input_stripe_error_card:'',
                        input_stripe_error_name:'',
                        input_stripe_name:'',


                        //STEP 5 
                        order:0,
                        pay_date:'',
            
                        async step_1_check_date(){
                            this.isLoading=true;
                            this.errors=[];
                            try {
                                const response = await 
                                axios.post('/reservation/step_1_check_date', {
                                    start_date: this.start_date,
                                    end_date: this.end_date,
                                    adults: this.adults,
                                    kids: this.kids,
                                })
            
                                this.rooms=response.data.rooms
                                this.night=response.data.night
                                this.step=2                    
                                
                            } catch (errors) {
                                this.validator_errors(errors)
                                
                            }
                            finally {
                                this.isLoading=false;
                            }                
                        },

                        step_2_select_room(id) {
            
                            this.room_id=id;
                            this.room_quantity=document.getElementById('quantity_availables_' + id).value;      
                            console.log(this.rooms)
                            this.room_selected = this.rooms.find(x => x.id === this.room_id);  
            
                            this.complements = this.room_selected.complements
            
                            this.step = 3;
                            

                            this.ids_complements_cheked = []
            
                        },
                        
                        complement_selected(complement_id, checked) {
                            
                            if (checked) {
            
                                //let complements_selected = this.complements.find(x => x.id === complement_id);
                                console.log(complement_id)
                                this.ids_complements_cheked.push(complement_id)
            
                            } else {
                                
                                this.ids_complements_cheked=this.ids_complements_cheked.filter(x => x !==complement_id);
                            }  
                            console.log(this.ids_complements_cheked);       
                        }, 

                        async step_3_confirmation() {
            
                            this.isLoading=true;                
                            try {
                                const response = await 
                                    
                                    axios.post('/reservation/step_4_confirmation', {                            
            
                                        room_id:this.room_selected.id,
                                        room_quantity: this.room_quantity,
                                        ids_complements_cheked:this.ids_complements_cheked,
                                        
                                    })
            
                                    this.complements_cheked=response.data.complements_cheked;
                                    this.price_per_reservation=response.data.price_per_reservation;
                                    this.total_price=response.data.total_price;                    
            
                                    this.step=4                    
                                    
                                } catch (errors) {
                                    this.validator_errors(errors)
                                }
                                finally {
                                    this.isLoading=false;
                                }
                        },
                        async step_5_finalize(methodpayment){

                                try {
                                    const response = await 
                                    
                                    axios.post('/reservation/step_5_finalize', {                    
                                        methodpayment: methodpayment,

                                        client_name : this.client_name,
                                        client_phone : this.client_phone,
                                        client_email : this.client_email,
                                        client_email_confirmation : this.client_email_confirmation,
                                        client_country : this.client_country,
                                        client_city : this.client_city,
                                        client_check_in : this.client_check_in,
                                        client_special_request : this.client_special_request,                                        

                                    })

                                    this.order=response.data.order
                                    this.step=5    
                                    
                                } catch (errors) {
                                    this.validator_errors(errors)
                                }
                                finally {
                                    this.isLoading=false;
                                }

                        },
                        
                        formatNumber(n) {
            
                            numberFormat = new Intl.NumberFormat('de-DE', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })
                            return numberFormat.format(parseFloat(n))
            
            
                        },

                        init() {
                            this.$nextTick(() => {
                                
                                const calendar_start_date =  flatpickr('#step_1_start_date', {
                                    altInput: true,
                                    altFormat: 'F j, Y',
                                    dateFormat: 'Y-m-d',
                                    defaultDate: this.start_date,
                                    minDate: this.start_date,
                                    onClose: function(selectedDates, dateStr, instance){
                                                
                                        let addDays=selectedDates[0].fp_incr(1)
                                        if(selectedDates[0] >= calendar_end_date.selectedDates[0]){            
                                            calendar_end_date.setDate(addDays)    
                                        }                                        
                                        calendar_end_date.config.minDate = addDays //add +1 days
                                        //document.getElementById('step_1_end_date').dispatchEvent(new Event('input'));
                                        
                                    } 
                                });
            
                                const calendar_end_date =  flatpickr('#step_1_end_date', {
                                    altInput: true,
                                    altFormat: 'F j, Y',
                                    dateFormat: 'Y-m-d',
                                    defaultDate: this.end_date,
                                    minDate: this.end_date,
                                });
                                
                            });                
                        },

                        init_stripe(stripe_key) {
                            this.$nextTick(() => {
                                
                                var style = {
                                    base: {
                                        color: '#303238',
                                        fontSize: '16px',
                                        fontFamily: '"Open Sans", sans-serif',
                                        fontSmoothing: 'antialiased',
                                        '::placeholder': {
                                            color: '#CFD7DF',
                                        },
                                    },
                                    invalid: {
                                        color: '#e5424d',
                                        ':focus': {
                                            color: '#303238',
                                        },
                                    },
                                };
                                const stripe = Stripe(stripe_key);
                                const elements = stripe.elements();
                                const cardElement = elements.create('card', {
                                    style: style
                                });
                                cardElement.mount('#card-element');

                                //const cardHolderName = document.getElementById('card-holder-name');
                                const cardButton = document.getElementById('card-button');
                                
                                cardButton.addEventListener('click', async (e) => {
                                    
                                    this.input_stripe_error_name = "";
                                    this.input_stripe_error_card = "";                                    
                                    
                                    if(!this.input_stripe_name){
                                        this.input_stripe_error_name = 'El nombre del titular de la targeta es requerido';
                                        this.isLoading=false;
                                        return true;
                                    }

                                    this.isLoading=true;
                                    const { paymentMethod,errors} = await stripe.createPaymentMethod(
                                        'card', cardElement, {
                                            billing_details: {
                                                name: this.input_stripe_name
                                            }
                                        }
                                    );

                                    if (errors) { 
                                        this.isLoading=false;                               
                                        this.validator_errors(errors,'stripe')                                        
                                    } else {
                                        this.step_5_finalize(paymentMethod.id)
                                        cardElement.clear();
                                    }
                                });
                                
                                
                            });
                        },                   

                        validator_errors(errors,type=''){
                            
                            if(type=='stripe'){                                
                               
                                if (error.type == "validation_error") {

                                    this.input_stripe_error_card = errors.message
                                }

                                else {
                                    this.input_stripe_error_card = "Algo ha fallado con la pasarela de pago"
                                }
                            
                            }else{
                            
                                if(errors.response.status==422){// -->input laravel validator
                                    
                                    let er =  errors.response.data.errors
                                    for (let key in er) {                                    
                                        er[key] = er[key][0];                                   
                                    }
                                    this.errors=er;    

                                }
                                else{
                                    //window.location = '/'
                                    console.log(errors.response)
                                    
                                    if(errors.response.data.error){
                                        
                                        this.errors.default = errors.response.data.error  
                                    
                                    }else{
                                        
                                        this.errors.default='Ha ocurrido un error por favor intente mas tarde'
                                    }

                                    this.step=1
                                }

                            }

                        },
                    }))
                });
</script>
@push('scripts')
<script src="{{ mix('js/flatpickr.js') }}"></script>
@endpush
@endsection
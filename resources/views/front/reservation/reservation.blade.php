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

        <div x-show="step==1" x-transition.duration.500ms>
            @include('front.reservation.step_1_date')
        </div>

        <div x-show="step==2" x-transition.duration.500ms>
            @include('front.reservation.step_2_rooms')
        </div>

        <div x-show="step==3" x-transition.duration.500ms>
            @include('front.reservation.step_3_complements')
        </div>

        <div x-show="step==4" x-transition.duration.500ms>
            @include('front.reservation.step_4_user')
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

                    stripe_key:'',
        
                    async step_1_check_date(){
                        this.isLoading=true;
                        // Want to use async/await? Add the `async` keyword to your outer function/method.
                        
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
                            
                        } catch (error) {
                            this.errors()
                        }
                        finally {
                            this.isLoading=false;
                        }                
                    },

                    step_2_select_room(id) {
        
                        this.room_id=id;
                        this.room_quantity=document.getElementById('quantity_availables_' + id).value;      
        
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
        
                                this.room_selected=response.data.room;
                                this.complements_cheked=response.data.complements_cheked;
                                this.price_per_reservation=response.data.price_per_reservation;
                                this.total_price=response.data.total_price;                    
        
                                this.step=4                    
                                
                            } catch (error) {
                                this.errors()
                            }
                            finally {
                                this.isLoading=false;
                            }
                    },
                    async step_5_finalize(stripe_id){

                            try {
                                const response = await 
                                
                                axios.post('/reservation/step_5_finalize', {                    
                                    stripe_id: stripe_id,                           
                                })

                                this.room=response.data.room;
                                this.total_price=response.data.total_price;
                                this.complements_cheked=response.data.complements;

                                this.step=4                    
                                
                            } catch (error) {
                                this.errors()
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
                                    fontSize: '14px',
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

                            const cardHolderName = document.getElementById('card-holder-name');
                            const cardButton = document.getElementById('card-button');
                            const input_error = document.getElementById('error-card-input')
                            
                            cardButton.addEventListener('click', async (e) => {

                                input_error.innerText = ""
                                this.isLoading=true;
                                const { paymentMethod,error } = await stripe.createPaymentMethod(
                                    'card', cardElement, {
                                        billing_details: {
                                            name: cardHolderName.value
                                        }
                                    }
                                );

                                if (error) { 
                                    this.isLoading=false;                                   
                                    if (error.type == "validation_error") {

                                        input_error.innerText = error.message

                                    } else {
                                        input_error.innerText = "Algo ha fallado"
                                    }
                                } else {
                                    this.step_5_finalize(paymentMethod.id)
                                }
                            });
                            cardElement.addEventListener('change', function(event) {
                                input_error.innerText = ""
                            });
                        });
                    },

                   

                    errors(){
        
                    }
        
                }))
            });
</script>
@push('scripts')
<script src="{{ mix('js/flatpickr.js') }}"></script>
 

@endpush
@endsection
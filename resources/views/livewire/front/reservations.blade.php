<div>
    
    <div x-data="reservation_step">

        <div x-show="step==1" x-transition.duration.500ms>
            @include('livewire.front.step_1_date')
        </div>

        <div x-show="step==2" x-transition.duration.500ms>
            @include('livewire.front.step_2_rooms')
        </div>

        <div x-show="step==3" x-transition.duration.500ms>
            @include('livewire.front.step_3_complements')
        </div>
        verificar los datos de $client ... de donde salen
        <div x-show="step==4" x-transition.duration.500ms>
            @include('livewire.front.step_4_user')
        </div>

        {{-- <div x-show="step==5" x-transition.duration.500ms>
            @include('livewire.front.step_5_confirmation')
        </div> --}}

    </div>

    <script defer>
        document.addEventListener('alpine:init', () => {
        Alpine.data('reservation_step', () => ({
            step: 4,
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
            isLoading:false,

            async step_1_check_date(){
                this.isLoading=true;
                // Want to use async/await? Add the `async` keyword to your outer function/method.
                
                try {
                    const response = await 
                    axios.post('api/reservation/step_1_check_date', {
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

                this.room_selected.total_price_per_reservation = this.room_selected.price_per_quantity_room_selected[this.room_quantity];

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

                // .reduce para sumar el precio de la reservacion mas los complementos,
                //se pasa como valor incial el precio de la reservacion -> room_selected.total_price_per_reservation

                // this.total_price = this.complements_cheked.reduce(function(prev, complement){

                //     return prev + complement.total_price;

                // },this.room_selected.total_price_per_reservation);                

                // this.step = 4

                
                this.isLoading=true;                
                try {
                    const response = await 
                        
                        axios.post('api/reservation/step_4_confirmation', {                    
                            start_date: this.start_date,
                            end_date: this.end_date,
                            adults: this.adults,
                            kids: this.kids,

                            room_id:this.room_selected.id,
                            room_quantity: this.room_quantity,
                            ids_complements_cheked:this.ids_complements_cheked,
                            
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
            errors(){

            }

        }))
    });
    </script>
</div>
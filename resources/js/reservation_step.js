export default () => ({


    async step_1_check_date() {
        this.isLoading = true;
        this.errors = [];

        try {
            const response = await
                axios.post('/reservation/step_1_check_date', {
                    start_date: this.start_date,
                    end_date: this.end_date,
                    adults: this.adults,
                    kids: this.kids,
                })

            this.rooms = response.data.rooms;
            this.night = response.data.night
            this.step = 2


        } catch (errors) {

            this.validator_errors(errors)

        }
        finally {
            this.isLoading = false;
            this.scroll_top() //sube el scroll arriba       
        }
    },

    step_2_select_room(id) {

        this.room_id = id;
        this.room_quantity = document.getElementById('quantity_availables_' + id).value;

        this.room_selected = this.rooms.find(x => x.id === this.room_id);

        this.complements = this.room_selected.complements

        this.step = 3;


        this.ids_complements_cheked = []

        this.scroll_top()

    },

    complement_selected(complement_id, checked) {

        if (checked) {

            this.ids_complements_cheked.push(complement_id)

        } else {

            this.ids_complements_cheked = this.ids_complements_cheked.filter(x => x !== complement_id);
        }

    },

    async step_3_confirmation() {
        this.isLoading = true;
        this.errors = [];

        try {
            const response = await

                axios.post('/reservation/step_3_confirmation', {

                    room_id: this.room_selected.id,
                    room_quantity: this.room_quantity,
                    ids_complements_cheked: this.ids_complements_cheked,

                })

            this.complements_cheked = response.data.complements_cheked;
            this.price_per_reservation = response.data.price_per_reservation;
            this.sub_total_price = response.data.total_price;
            this.total_price = this.sub_total_price;
            this.step = 4;

        } catch (errors) {
            this.validator_errors(errors)
        }
        finally {
            this.isLoading = false;
            this.scroll_top()
        }
    },
    async step_4_finalize(payment_id) {
        
        try {
            const response = await

                axios.post('/reservation/step_4_finalize', {
                    methodpayment: payment_id,
                    client: this.client,
                    
                })

            this.order = response.data.order
            this.create_date = response.data.create_date
            this.step = 5

            let button_report = document.getElementById('report_pdf_button')
            button_report.href += `?order=${this.order}&email=${this.client.email}`;
            
            Livewire.emit('resetListReservations')



        } catch (errors) {
            this.validator_errors(errors)
        }
        finally {
            this.isLoading = false;
            this.scroll_top()
        }

    },
    async applyCodeDiscount() {

        this.discount.error_input = ''

        if (!this.discount.code) {
            this.discount.error_input = 'El codigo de descuento es requerido';
            return true;
        }

        this.isLoading = true;
        this.errors = [];

        try {
            const response = await
                axios.post('/reservation/dicount_code', {
                    code: this.discount.code,
                });
            this.total_price = response.data.total_price;
            this.discount.amount = response.data.discount_amount;
            this.discount.percent = response.data.discount_percent;

        } catch (errors) {
            this.total_price = this.sub_total_price;
            this.discount.amount = 0;
            this.discount.percent = 0;
            this.validator_errors(errors)
        }
        finally {
            this.isLoading = false;
        }
    },

    formatNumber(n) {
        n = n ? n : 0;// number NaN = 0
        return '$ ' + this.currencyFormat.format(parseFloat(n))
    },
    init() {        
        this.init_state()
        this.$nextTick(() => {
            
            this.start_date=document.getElementById('step_1_start_date').getAttribute('date-default');

            this.end_date=document.getElementById('step_1_end_date').getAttribute('date-default');
            
            const calendar_start_date = flatpickr('#step_1_start_date', {
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                defaultDate: this.start_date,
                minDate: this.start_date,
                onClose: function (selectedDates, dateStr, instance) {

                    let addDays = selectedDates[0].fp_incr(1)
                    if (selectedDates[0] >= calendar_end_date.selectedDates[0]) {
                        calendar_end_date.setDate(addDays)
                    }
                    calendar_end_date.config.minDate = addDays //add +1 days
                    //document.getElementById('step_1_end_date').dispatchEvent(new Event('input'));

                }
            });

            const calendar_end_date = flatpickr('#step_1_end_date', {
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                defaultDate: this.end_date,
                minDate: this.end_date,
            });

            //init stripe credit card
            this.init_stripe()

        });

        this.currencyFormat = Intl.NumberFormat('de-DE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
    },
    validator_errors(errors,status=null,msg='') {
        this.errors = [];
        if (errors.response.status == 422) {// -->input laravel validator


            let er = errors.response.data.errors
            for (let key in er) {
                this.errors.push(er[key][0])
            }
        }
        if (errors.response.status == 404) { //fail session data backend
            this.step = 1;
            this.errors[0] = 'Al parecer hubo un error!'
        }
        else {
            //window.location = '/'
            if (errors.response.data.error) {

                this.errors[0] = errors.response.data.error

            } else {

                this.errors[0] = 'Ha ocurrido un error por favor intente mas tarde'
            }

            
        }
        this.scroll_top()

    },
    scroll_top() {
        document
            .getElementById('container-main')
            .scrollIntoView({ behavior: 'smooth' });
    },
    init_stripe(){
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
        let stripe_key = document.getElementById('card-element').getAttribute('stripe-key');
        let stripe = Stripe(stripe_key);
        let elements = stripe.elements();
        let cardElement = elements.create('card', {
            style: style
        });
        cardElement.mount('#card-element');

        let button_stripe = document.getElementById('button_stripe');

        button_stripe.addEventListener('click', async (e) => {
            
            // this.step_4_finalize('test')
            // return true;
            
            this.stripe.error_name = "";
            this.stripe.error_card = "";
            
            if (!this.stripe.name) {//titular
                this.errors[0] = 'El nombre del titular de la targeta es requerido';
                this.scroll_top()
                this.isLoading = false;
                return true;
            }

            this.isLoading = true;
                this.errors = [];
                const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', cardElement, {
                    billing_details: {
                        name: this.stripe.name
                    }
                }
            );

            if (error) {
                this.isLoading = false;
                this.errors[0] = error.message;
                this.scroll_top()
            }
            else {
                this.step_4_finalize(paymentMethod.id)
            }

        });
    },
    init_state() {
        this.step = 1;
        this.night = 0;
        this.start_date = '';
        this.end_date = '';
        this.adults = 1;
        this.kids = 0;
        this.room_quantity = '';

        this.complements = [];
        this.ids_complements_cheked = [];
        this.complements_cheked = [];//solo para el paso final
        this.rooms = [];
        this.room_selected = {};

        this.sub_total_price = 0;
        this.total_price = 0;
        this.price_per_reservation = 0;
        this.isLoading = false;

        //step 4
        this.client = {
            name: '',
            phone: '',
            email: '',
            email_confirmation: '',
            country: '',
            city: '',
            check_in: '',
            special_request: '',
        }

        this.discount = {
            code: '',
            amount: 0,
            percent: 0,
            error_input: ''
        };

        //stripe
        this.stripe = {
            name: '',//titular targeta
            error_name: '',
            error_card: '',
        }
        // this.stripe= '';
        // this.cardElement= '';
        // this.stripe_key= '';
        // this.input_stripe_name= '';
        // this.input_stripe_error_card= '';
        // this.input_stripe_error_name= '';


        //STEP 5 
        this.order = 0;
        this.create_date = '';

        this.errors = [];
    },
})
export default () => ({
    step: 1,
    night: 0,
    start_date: '',
    end_date: '',
    adults: 1,
    kids: 0,
    room_quantity: '',

    complements: [],
    ids_complements_cheked: [],
    complements_cheked: [],//solo para el paso final
    rooms: [],
    room_selected: {},

    total_price: 0,
    price_per_reservation: 0,
    isLoading: false,

    //step 4
    client_name: '{{$client->name}}',
    client_phone: '{{$client->phone}}',
    client_email: '{{$client->email}}',
    client_email_confirmation: '{{$client->email}}',
    client_country: '{{$client->country}}',
    client_city: '{{$client->city}}',
    client_check_in: '',
    client_special_request: '{{$client->special_request}}',

    //stripe
    stripe_key: '',
    input_stripe_error_card: '',
    input_stripe_error_name: '',
    input_stripe_name: '',

    //STEP 5 
    order: 0,
    create_date: '',


    errors: [],

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
        try {
            const response = await

                axios.post('/reservation/step_4_confirmation', {

                    room_id: this.room_selected.id,
                    room_quantity: this.room_quantity,
                    ids_complements_cheked: this.ids_complements_cheked,

                })

            this.complements_cheked = response.data.complements_cheked;
            this.price_per_reservation = response.data.price_per_reservation;
            this.total_price = response.data.total_price;

            this.step = 4


        } catch (errors) {
            this.validator_errors(errors)
        }
        finally {
            this.isLoading = false;
            this.scroll_top()
        }
    },
    async step_5_finalize(methodpayment) {

        try {
            const response = await

                axios.post('/reservation/step_5_finalize', {
                    methodpayment: methodpayment,

                    client_name: this.client_name,
                    client_phone: this.client_phone,
                    client_email: this.client_email,
                    client_email_confirmation: this.client_email_confirmation,
                    client_country: this.client_country,
                    client_city: this.client_city,
                    client_check_in: this.client_check_in,
                    client_special_request: this.client_special_request,

                })

            this.order = response.data.order
            this.create_date = response.data.create_date
            this.step = 5


        } catch (errors) {
            this.validator_errors(errors)
        }
        finally {
            this.isLoading = false;
            this.scroll_top()
        }
    },

    formatNumber(n) {
        n = n ? n : 0;// number NaN
        let numberFormat = new Intl.NumberFormat('de-DE', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })
        return numberFormat.format(parseFloat(n))


    },

    init() {
        this.$nextTick(() => {

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
            
            const stripe_id =  document.getElementById('card-element').getAttribute('data-stripe_id');
            
            this.init_stripe(stripe_id)
            
            
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
            const stripe_id =  document.getElementById('card-element').getAttribute('data-stripe_id');
            const stripe = Stripe(stripe_key);
            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                style: style
            });
            cardElement.mount('#card-element');

            const cardButton = document.getElementById('card-button');

            cardButton.addEventListener('click', async (e) => {

                this.input_stripe_error_name = "";
                this.input_stripe_error_card = "";

                if (!this.input_stripe_name) {
                    this.input_stripe_error_name = 'El nombre del titular de la targeta es requerido';
                    this.isLoading = false;
                    return true;
                }

                this.isLoading = true;
                const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', cardElement, {
                    billing_details: {
                        name: this.input_stripe_name
                    }
                }
                );

                if (error) {
                    this.isLoading = false;
                    this.input_stripe_error_card = error.message
                }

                else {

                    this.step_5_finalize(paymentMethod.id)
                    cardElement.clear();
                }
            });


        });
    },

    validator_errors(errors) {

        if (errors.response.status == 422) {// -->input laravel validator

            let er = errors.response.data.errors
            for (let key in er) {
                er[key] = er[key][0];
            }
            this.errors = er;

        }
        else {
            //window.location = '/'
            if (errors.response.data.error) {

                this.errors.default = errors.response.data.error

            } else {

                this.errors.default = 'Ha ocurrido un error por favor intente mas tarde'
            }
            scroll_top()
            this.step = 1
        }

    },
    scroll_top() {
        document
            .getElementById('container-main')
            .scrollIntoView({ behavior: 'smooth' });
    }
})
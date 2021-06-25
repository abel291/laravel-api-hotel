require('./bootstrap');

require('alpinejs');

import flatpickr from "flatpickr";
import language from 'flatpickr/dist/l10n/es';
flatpickr.localize(language.es);
/*
const end_date = flatpickr('#end_date', {                
    altInput: true,
    altFormat: 'F j, Y',
    dateFormat: 'Y-m-d',
    
    
});

const start_date =  flatpickr('#start_date', {                
    altInput: true,
    altFormat: 'F j, Y',
    dateFormat: 'Y-m-d',
    minDate: 'today',
    onClose: function(selectedDates, dateStr, instance){
        //cuando se cierra el calendario de la fechha de inicio se toma esa fecha se le agrega un dia mas y se colola como el primer dia de la fecha de salida        
        end_date.config.minDate=selectedDates[0].fp_incr(1) //add +1 dyas       
        
    }
    
});

flatpickr('#check_in', {                
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    minDate: 'today',
    
});
*/


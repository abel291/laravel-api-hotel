

import flatpickr from "flatpickr";
import language from 'flatpickr/dist/l10n/es';
flatpickr.localize(language.es);

const calendar_start_date =  flatpickr("#start_date", {
    dateFormat: "D, d M y",
    defaultDate: 'today',
    minDate: 'today',
    onClose: function(selectedDates, dateStr, instance){
                
        let addDays=selectedDates[0].fp_incr(1)
        if(selectedDates[0] >= calendar_end_date.selectedDates[0]){            
            calendar_end_date.setDate(addDays)    
        }                                        
        calendar_end_date.config.minDate = addDays //add +1 days
        
           
    } 
});
const calendar_end_date =  flatpickr("#end_date", {
    dateFormat: "D, d M y",
    defaultDate: 'today',
    minDate: 'today',
});
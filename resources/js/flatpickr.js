

const start_date = document.getElementById('start_date')
const end_date = document.getElementById('end_date')

const calendar_start_date =  flatpickr("#start_date", {
    altInput: true,
    altFormat: 'F j, Y',
    dateFormat: 'Y-m-d',
    defaultDate: 'today',
    minDate: 'today',
    onClose: function(selectedDates, dateStr, instance){
                
        let addDays=selectedDates[0].fp_incr(1)
        if(selectedDates[0] >= calendar_end_date.selectedDates[0]){            
            calendar_end_date.setDate(addDays)    
        }                                        
        calendar_end_date.config.minDate = addDays //add +1 days
        end_date.dispatchEvent(new Event('input'));           
    } 
});

const calendar_end_date =  flatpickr("#end_date", {
    altInput: true,
    altFormat: 'F j, Y',
    dateFormat: 'Y-m-d',
    defaultDate:calendar_start_date.selectedDates[0].fp_incr(1),
    minDate:calendar_start_date.selectedDates[0].fp_incr(1),
});


import Sortable from 'sortablejs';


var gridDemo = document.getElementById('sortable-item');
new Sortable(gridDemo, {
    animation: 150,
    ghostClass: 'bg-gray-700',
    
    onChange: function (/**Event*/evt) {
        order_image_input()        
    },    
});
function order_image_input() {
    
    var input_order = gridDemo.querySelectorAll('input.images_order')

    for (let i = 0; i < input_order.length; ++i) {
        input_order[i].value = i+1
        input_order[i].dispatchEvent(new Event('input'));
    }
    console.log('asd')

}
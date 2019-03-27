document.addEventListener('DOMContentLoaded', function(){ 
    console.log('code running');



    const plusButtons = document.querySelector('#fflPlusBtn');
    console.log(plusButtons);
    // plusButtons.forEach(function(button) {
    //     button.addEventListener('click', function(evt) {
    //         evt.preventDefault();
    //         console.log('CLUCK');
    //     })
    // });


}, false);

jQuery( document.body ).on( 'updated_cart_totals', function(){
    console.log('something happened')
});

jQuery(document).ready(function($){
    // now you can use jQuery code here with $ shortcut formatting
    // this will execute after the document is fully loaded
    // anything that interacts with your html should go here
    const plusButtons = document.querySelector('.hamster');
    console.log(plusButtons);


}); 

(function($){
    $('body').on( 'added_to_cart', function(){
        // Testing output on browser JS console
        console.log('added_to_cart'); 
        // Your code goes here
    })});

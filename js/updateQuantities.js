if (myAjax.showSubtotal !== '1') {
    if (document.styleSheets.length == 0) {
        document.head.appendChild(document.createElement("style"));
    }
    
    var rule = '.woocommerce-mini-cart__total {display: none;}';
    document.styleSheets[0].insertRule(rule);
} 

// Allow the decrement of the new quantity field.
jQuery('body').on('load', '.widget_shopping_cart', function(evt) {
    // evt.preventDefault();
    //var currentValue = parseInt(this.parentElement.querySelector('.uncouthQty').innerHTML);
    //this.parentElement.querySelector('.uncouthQty').innerHTML = --currentValue;
    console.log('LOAD FIRED')
    var subtotal = document.querySelector('.woocommerce-mini-cart__total');
    console.log(subtotal);
});

// Allow the decrement of the new quantity field.
jQuery('body').on('click', '.uncouthQtyMinusButton', function(evt) {
    evt.preventDefault();
    var currentValue = parseInt(this.parentElement.querySelector('.uncouthQty').innerHTML);
    this.parentElement.querySelector('.uncouthQty').innerHTML = --currentValue;
});

// Allow the increment of the new quantity field.
jQuery('body').on('click', '.uncouthQtyPlusButton', function(evt) {
    evt.preventDefault();
    var currentValue = parseInt(this.parentElement.querySelector('.uncouthQty').innerHTML);
    this.parentElement.querySelector('.uncouthQty').innerHTML = ++currentValue;
    evt.stopPropagation();
});

// Ajax over to the updateQuantities method.
jQuery('body').on('click', '#updateQuantitiesButton', function(evt) {
    evt.preventDefault();


    // Here we will form an array containing objects.

    /*
    

    */

    // Grab all of the quantity controls in the cart and check the order.

    var quantityControls = document.querySelectorAll('.uncouthMiniCartQtyControls');
    // console.log(quantityControls);

    var dataDict = [];

    quantityControls.forEach(function(quantityControl) {
        // dataDict[]

        var cartKey = jQuery(quantityControl.querySelector('.uncouthQty')).data('cart_key');
        console.log('The cart key: ' + cartKey);

        // Now grab the qty
        var quantity = quantityControl.querySelector('.uncouthQty').innerHTML;
        console.log('The quantity: ' + quantity);

        // Store the quantity with the cart key.
        // dataDict[cartKey] = quantity;
        dataDict.push({
            cartKey: cartKey,
            qty: quantity
        });

        
    });

    // var vals = JSON.stringify(dataDict);
    // console.log('vals: ', vals);
    // Make sure this doesn't explode...

    // <i class="fas fa-circle-notch fa-spin"></i>

    var updateButton = document.querySelector('#updateQuantitiesButton');
    console.log('update button', updateButton)
    updateButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';


    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : myAjax.ajaxurl,
        data : { action: 'updateQuantities', fieldData: dataDict },
        success: function(response) {
            if(JSON.parse(response.status == 1)) {
                var prices = response.newPrices;
                var miniCartItems = document.querySelectorAll('.woocommerce-mini-cart-item.mini_cart_item > a');

                miniCartItems.forEach(function(item) {
                    if (prices[item.getAttribute('data-cart_item_key')] !== null) {
                        var numeric = parseFloat(prices[item.getAttribute('data-cart_item_key')]);
                        var num = '£' + numeric.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        item.parentElement.querySelector('.uncouthPrice').innerHTML = num;
                    }
                });

                var subtotalElement = document.querySelector('.woocommerce-Price-amount');

                // We are replacing it with another span with the same class so create one:
                var replacementSpan = document.createElement('span');
                replacementSpan.classList.add('woocommerce-Price-amount');
                replacementSpan.classList.add('amount');

                // Next we create a span for the currency symbol:
                var currencySymbol = document.createElement('span');
                currencySymbol.classList.add('woocommerce-Price-currencySymbol');

                // Finally a text node
                var numericSubtotal = parseFloat(response.subtotal);
                var numSubtotal = '£' + numericSubtotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                //item.parentElement.querySelector('.uncouthPrice').innerHTML = num;
                var total = document.createTextNode(numSubtotal);

                replacementSpan.appendChild(currencySymbol);
                replacementSpan.appendChild(total);

                subtotalElement.parentNode.replaceChild(replacementSpan, subtotalElement);



            } else {
            //    console.log(response);
            }
            //console.log(response);
        },
        complete: function(response) {
            updateButton.innerHTML = 'Update Cart';
            //console.log(response);
        }
    });
});

/*
    What do we need?
*/
jQuery('body').on('click', '.widget_shopping_cart_content', function(evt) {
    console.log('parent got a click');
    // evt.stopPropagation();
    // return false;
});

// jQuery('.widget_shopping_cart_content').click(function(evt) {
//     console.log('parent got a click')
//     evt.stopPropagation();
// });

jQuery('body').on('mouseout', '#site-header-cart', function(evt) {
//    console.log('mouseout')
    // return false;
});

jQuery('body').on('mouseenter', '#site-header-cart', function(evt) {
//    console.log('mouseenter')
});

jQuery('body').on('mouseleave', '#site-header-cart', function(evt) {
//    console.log('mouseleave')
    // return false;
});

jQuery('body').on('pointerleave', '#site-header-cart', function(evt) {
//    console.log('mouseleave')
    // return false;
});

jQuery('body').on('pointerout', '#site-header-cart', function(evt) {
//    console.log('mouseleave')
    // return false;
});



jQuery('body').on('hover', '#site-header-cart', function(evt) {

});

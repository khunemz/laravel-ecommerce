const Handlebars = require("handlebars");
require("handlebars/runtime");
/** by chutipong roobklom */

const RENDER_HBS = function (templateId, targetId, data) {
    var template = document.getElementById(templateId).innerHTML;
    // var compiled_template = Handlebars.compile(template);
    var compiled_template = compileWithExtras(template);
    var rendered = compiled_template(data);
    document.getElementById(targetId).innerHTML = rendered;
};

function compileWithExtras(template, options) {
    var template = Handlebars.compile(template, options);
    return function () {
        var rendered = template.apply(null, arguments);
        return rendered;
    };
}

Handlebars.registerHelper("numberFormat", function (value, options) {
    var dl = options.hash["decimalLength"] || 2;
    var ts = options.hash["thousandsSep"] || ",";
    var ds = options.hash["decimalSep"] || ".";
    var value = parseFloat(value);
    var re = "\\d(?=(\\d{3})+" + (dl > 0 ? "\\D" : "$") + ")";
    var num = value.toFixed(Math.max(0, ~~dl));
    return (ds ? num.replace(".", ds) : num).replace(
        new RegExp(re, "g"),
        "$&" + ts
    );
});

$(document).ready(function () {
    finalizeLoading();
    // $('#decrease-button').on('click', function(e) {
    //     var qty = $('#quantity').val();
    //     qty--;
    //     if(qty <= 1) {
    //         qty = 1;
    //         disabled('decrease-button');
    //     } else {
    //         enable('decrease-button');
    //     }
    //     $('#quantity').val(qty);
    //     // update basket 
    // });

    // $('#increase-button').on('click', function(e) {
    //     var qty = $('#quantity').val();
    //     qty++;
    //     if(qty >= 1) {
    //         enable('decrease-button');
    //     }
    //     $('#quantity').val(qty);
    // });

    // $('#quantity').on('change',function(e) {
    //     var qty = e.target.value;
    //     if(qty <= 1) {
    //         disabled('decrease-button');
    //     } else {
    //         enable('decrease-button');
    //     }
    // });

    const increaseBtns = document.getElementsByClassName('increase-button');
    for (let i = 0; i < increaseBtns.length; i++) {
        const element = increaseBtns[i];
        element.addEventListener('click', function(e) {
            const dataSet = this.dataset;
            const basket_item_id = dataSet.id;
            const product_id = dataSet.productId;

            let quantity =  $(`input.basket-item-quantity[data-id=${basket_item_id}]`).val();
            quantity++;
            if(quantity >= 1) {
                $(`input.increase-button[data-id=${basket_item_id}]`).prop('disabled', false);
            }
            $(`input.basket-item-quantity[data-id=${basket_item_id}]`).val(quantity);
            update_basket(basket_item_id, quantity, product_id);
        });
    }
    const decreaseBtns = document.getElementsByClassName('decrease-button');
    for (let i = 0; i < decreaseBtns.length; i++) {
        const element = decreaseBtns[i];
        element.addEventListener('click', function(e) {
            const dataSet = this.dataset;
            const basket_item_id = dataSet.id;
            const product_id = dataSet.productId;

            let quantity =  $(`input.basket-item-quantity[data-id=${basket_item_id}]`).val();
            quantity--;
            if(quantity <= 1) {
                quantity = 1
                $(`input.decrease-button[data-id=${basket_item_id}]`).prop('disabled', true);
            } else {
                $(`input.decrease-button[data-id=${basket_item_id}]`).prop('disabled', false);
            }
            $(`input.basket-item-quantity[data-id=${basket_item_id}]`).val(quantity);

            update_basket(basket_item_id, quantity, product_id);
        });
    }

    const baskItems = document.getElementsByClassName('basket-item-quantity');
    for (let i = 0; i < baskItems.length; i++) {
        const element = baskItems[i];
        element.addEventListener('change', function(e) {
            const quantity = e.target.value;    
            const dataSet = this.dataset;
            const basket_item_id = dataSet.id;
            const product_id = dataSet.productId;
            update_basket(basket_item_id, quantity, product_id);
        });
    }

    const elems = document.getElementsByClassName('delete-button');
    for (let i = 0; i < elems.length; i++) {
        const element = elems[i];
        element.addEventListener('click', function(e) {
            const dataSet = this.dataset;
            const basket_item_id = dataSet.id;   
            delete_item(basket_item_id);
        });
    }
});


function delete_item(id) {
    $.get(`${BASE_URL}/sale/delete/${id}`, {})
    .done(function(data, xhrStatus, jqXHR) {
        if (xhrStatus == "success") {
            window.location.reload();
        }
    })
    .fail(function(data, xhrStatus, jqXHR) {
        console.log(xhrStatus)
    });
}

function update_basket(id , quantity, product_id) {
    console.log(product_id);
    $.post(`${BASE_URL}/sale/update_cart`, {
        _token: CSRF_TOKEN,
        basket_item_id: id,
        product_id: product_id,
        quantity: quantity,
    })
    .done(function(data, xhrStatus, jqXHR) {
        if (xhrStatus == "success") {
            // window.location.reload(); 
            console.log(data);
        }
    })
    .fail(function(data, xhrStatus, jqXHR) {
        console.log(xhrStatus)
    });
}
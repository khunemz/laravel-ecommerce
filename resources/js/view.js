const Handlebars = require("handlebars");
require("handlebars/runtime");
const Mustache = require('mustache');
const ImageZoom = require('js-image-zoom');
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
    $('#quantity').val(1);
    document.getElementById('decrease-button').classList.add('disabled');
    $('#decrease-button').on('click', function(e) {
        var qty = $('#quantity').val();
        qty--;
        if(qty <= 1) {
            qty = 1;
            disabled('decrease-button');
        } else {
            enable('decrease-button');
        }
        $('#quantity').val(qty);
    });

    $('#increase-button').on('click', function(e) {
        var qty = $('#quantity').val();
        qty++;
        if(qty >= 1) {
            enable('decrease-button');
        }
        $('#quantity').val(qty);
    });

    $('#quantity').on('change',function(e) {
        var qty = e.target.value;
        if(qty <= 1) {
            disabled('decrease-button');
        } else {
            enable('decrease-button');
        }
    });

    $('#add-to-cart-button').on('click', function() {
        // ajax add cart

        var product_id = $('#card-product-view-item').attr('data-id');
        var quantiy = $('#quantity').val();
        
        const data = {
            _token: CSRF_TOKEN,
            product_id: product_id,
            quantity: quantiy,
        };
        $.post(`${BASE_URL}/sale/addCart`, data).done(function(data, xhrStatus, jqXHR) {
            if (xhrStatus == "success") {
                const basket_count = data.data.total_quantity;
                document.getElementById('basket-count').innerHTML = basket_count;
            }
        }).fail(function(data, xhrStatus, jqXHR) {
            console.log(jqXHR);
        });
    })

});

function disabled(id) {
    document.getElementById('decrease-button').classList.add('disabled');
}

function enable(id) {
    document.getElementById(id).classList.remove('disabled');
}

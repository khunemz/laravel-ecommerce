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

    const elems = document.getElementsByClassName('delete-button');
    for (let i = 0; i < elems.length; i++) {
        const element = elems[i];
        element.addEventListener('click', function(e) {
            const dataSet = this.dataset;
            const basket_item_id = dataSet.id;            
            delete_item(basket_item_id);
        });
    }

    document.getElementById('make-order-button').addEventListener('click', function() {
        processOrder();
    });
});

function processOrder() {
    const customer_address_id = document.getElementById('customer_address_id');
    $.post(`${BASE_URL}/sale/processorder`, {
        _token: CSRF_TOKEN, 
        customer_address_id: customer_address_id        
        })
        .done(function(data, xhrStatus, jqXHR) {
            if (xhrStatus == "success") {
                window.location.href = '/'
            }
        })
        .fail(function(data, xhrStatus, jqXHR) {
            console.log(xhrStatus)
        })
}

function disabled(id) {
    document.getElementById(id).classList.add("disabled");
}

function enable(id) {
    document.getElementById(id).classList.remove("disabled");
}

function delete_item(id) {
    $.get(`${BASE_URL}/sale/delete/${id}`, {})
    .done(function(data, xhrStatus, jqXHR) {
        if (xhrStatus == "success") {
            window.location.reload();
        }
    })
    .fail(function(data, xhrStatus, jqXHR) {
        console.log(xhrStatus)
    })
}
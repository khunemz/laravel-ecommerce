//require('./bootstrap');
const Handlebars = require("handlebars");
require("handlebars/runtime");
/** by chutipong roobklom */

const BASE_URL = window.location.href;

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
    let page = 1;
    getCategory();
    getProducts();
    finalizeLoading();

    document.getElementById('button-load-more').addEventListener('click',function(){
      const data = this.dataset;
      this.page = data.page;
      this.page++;
      const limit = 30;
      
      
    });

    function finalizeLoading() {
        const el = document.querySelector(".loading-skeleton");
        if (el.classList.contains("loading-skeleton")) {
            el.classList.remove("loading-skeleton");
        }
    } 
  
    function getProducts(page, limit) {
        $.ajax({
            url: `/getProducts?page=${page}&limit=${limit}`,
            success: function (data, xhrStatus, jqXHR) {
                if (xhrStatus == "success") {
                    RENDER_HBS("product_card_template", "product_card_target", {
                        products: data,
                    });
                }
            },
            error: function (data, xhrStatus, jqXHR) {
                console.log(xhrStatus);
            },
        });
    }

    function getCategory() {
        $.ajax({
            url: "/getCategory",
            success: function (data, xhrStatus, jqXHR) {
                if (xhrStatus == "success") {
                    RENDER_HBS(
                        "category_card_template",
                        "category_card_target",
                        { categories: data }
                    );
                }
            },
            error: function (data, xhrStatus, jqXHR) {
                console.log(xhrStatus);
            },
        });
    }
});

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
    getProvinces();
});


function getProvinces() {
    $.ajax({
        url: "/sale/get_provinces",
        success: function (data, xhrStatus, jqXHR) {
            if (xhrStatus == "success") {
                RENDER_HBS(
                    "province_template",
                    "province_target",
                    { 
                        provinces: data 
                    }
                );

                document.getElementById('province_combobox').addEventListener('click', function(e){
                    const provinceId = e.target.value;
                    getDistricts(provinceId);
                });
            }
        },
        error: function (data, xhrStatus, jqXHR) {
            console.log(xhrStatus);
        },
    });
}

function getDistricts(province_id) {
    $.ajax({
        url: `/sale/get_districts/${province_id}`,
        success: function (data, xhrStatus, jqXHR) {
            if (xhrStatus == "success") {
                RENDER_HBS(
                    "district_template",
                    "district_target",
                    { 
                        districts: data 
                    }
                );
                document.getElementById('district_combobox').addEventListener('click', function(e){
                    const district_id = e.target.value;
                    console.log('district id: ', district_id)
                    getSubDistricts(district_id);
                })
            }
        },
        error: function (data, xhrStatus, jqXHR) {
            console.log(xhrStatus);
        },
    });
}


function getSubDistricts(district_id) {
    $.ajax({
        url: `/sale/get_sub_districts/${district_id}`,
        success: function (data, xhrStatus, jqXHR) {
            if (xhrStatus == "success") {
                RENDER_HBS(
                    "subdistrict_template",
                    "subdistrict_target",
                    { 
                        subdistricts: data 
                    }
                );

                RENDER_HBS(
                    "zipcode_template",
                    "zipcode_target",
                    null
                );
            }
        },
        error: function (data, xhrStatus, jqXHR) {
            console.log(xhrStatus);
        },
    });
}
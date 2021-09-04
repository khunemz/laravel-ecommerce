//require('./bootstrap');
const Handlebars = require('handlebars')
require('handlebars/runtime')
/** by chutipong roobklom */

const BASE_URL = window.location.href;

const RENDER_HBS = function(templateId, targetId, data) {
  var template = document.getElementById(templateId).innerHTML;
  var compiled_template = Handlebars.compile(template);
  var rendered = compiled_template(data);
  document.getElementById(targetId).innerHTML = rendered;
}

Handlebars.registerHelper('numberFormat', function (value, options) {
  var dl = options.hash['decimalLength'] || 2;
  var ts = options.hash['thousandsSep'] || ',';
  var ds = options.hash['decimalSep'] || '.';
  var value = parseFloat(value);
  var re = '\\d(?=(\\d{3})+' + (dl > 0 ? '\\D' : '$') + ')';
  var num = value.toFixed(Math.max(0, ~~dl));
  return (ds ? num.replace('.', ds) : num).replace(new RegExp(re, 'g'), '$&' + ts);
});


document.addEventListener('DOMContentLoaded', function() {
  // remove all loading skeleton
  finalizeLoading();
}, false);

function finalizeLoading() {
  const el = document.querySelector('.loading-skeleton');
  if (el.classList.contains("loading-skeleton")) {
    el.classList.remove("loading-skeleton");
  }
}

$.ajax({
  url: '/getProducts',
  success: function(data, xhrStatus, jqXHR) {
    if(xhrStatus == "success") {
      let products = data;
      RENDER_HBS('product_card_template', 'product_card_target', { products: data});
      finalizeLoading();
    }
  },
  error: function(data, xhrStatus, jqXHR) {
    console.log(xhrStatus);
  }
});


$.ajax({
  url: '/getCategory',
  success: function(data, xhrStatus, jqXHR) {
    if(xhrStatus == "success") {
      RENDER_HBS('category_card_template', 'category_card_target', { categories: data});
      finalizeLoading();
    }
  },
  error: function(data, xhrStatus, jqXHR) {
    console.log(xhrStatus);
  }
});
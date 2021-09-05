const Handlebars = require("handlebars");
require("handlebars/runtime");
const Mustache = require('mustache');
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
  var that = this;
  this.PAGE = 1;
  this.LIMIT = 8;
  this.CATEGORY = 0;
  getCategory();
  getProducts(this.PAGE, this.LIMIT, this.CATEGORY);
  finalizeLoading();

  $("#button-load-more").on("click", function () {
      const data = this.dataset;
      let limit = parseInt(data.limit);
      limit += 8;
      data.limit = limit;
      getProducts(that.PAGE, limit, that.CATEGORY);
  });

  function finalizeLoading() {
      const el = document.querySelector(".loading-skeleton");
      if (el.classList.contains("loading-skeleton")) {
          el.classList.remove("loading-skeleton");
      }
  }

  function getProducts(page, limit, category) {
      var search = "";
      category ? category : 0;

      $.get(`/getProducts/${page}/${limit}/${category}`,{})
      .done(function(data, xhrStatus, jqXHR) {
        if (xhrStatus == "success") {
            RENDER_HBS("product_card_template", "product_card_target", {
                products: data,
            });
        }
      }).fail(function(data, xhrStatus, jqXHR) {
        console.log(xhrStatus);
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
                  for (let i = 0; i < data.length; i++) {
                      const d = data[i];
                      const element = document.getElementById(
                          `category-item-${d.id}`
                      );
                      element.addEventListener("click", function (e) {
                          that.CATEGORY = d.id;
                          this.PAGE = 1;
                          this.LIMIT =  0;
                          getProducts(that.PAGE, that.LIMIT, d.id);
                      });
                  }
              }
          },
          error: function (data, xhrStatus, jqXHR) {
              console.log(xhrStatus);
          },
      });
  }
});

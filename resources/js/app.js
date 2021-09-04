//require('./bootstrap');
document.addEventListener('DOMContentLoaded', function() {
  // remove all loading skeleton
  const el = document.querySelector('.loading-skeleton');
  if (el.classList.contains("loading-skeleton")) {
    el.classList.remove("loading-skeleton");
  }
}, false);
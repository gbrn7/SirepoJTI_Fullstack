const form = document.querySelectorAll("form");
form.forEach(e => {
  e.addEventListener('submit', function () {
    document.querySelector("html").style.cursor = "wait";
    document.querySelector(".loading-wrapper").classList.remove('d-none');
  })
});

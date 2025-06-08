const form = document.querySelectorAll("form");
form.forEach(e => {
  e.addEventListener('submit', function () {
    document.querySelector(".loading-wrapper").classList.remove('d-none');

    if (!e.classList.contains('no-interval-load')) {
      setInterval(() => {
        document.querySelector("html").style.cursor = "auto";
        document.querySelector(".loading-wrapper").classList.add('d-none');
      }, 3000);
    }
  })
});
const submitBtns = document.querySelectorAll(".btn-submit");
submitBtns.forEach(e => {
  e.addEventListener('click', function () {
    document.querySelector("html").style.cursor = "wait";
    document.querySelector(".loading-wrapper").classList.remove('d-none');
  })
});

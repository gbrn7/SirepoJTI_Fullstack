const submitBtn = document.querySelector(".btn-submit");
submitBtn.addEventListener('click', function () {
  document.querySelector("html").style.cursor = "wait";
  document.querySelector(".loading-wrapper").classList.remove('d-none');
})
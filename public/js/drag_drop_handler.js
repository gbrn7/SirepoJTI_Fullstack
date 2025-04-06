const dropArea = document.querySelector("#drop-area");
const inputFile = document.querySelector("#input-file");
const imageView = document.querySelector(".img-view");

$('.input-file').change(function (e) {
  e.preventDefault();
  const [file] = e.target.files;
  $(this).closest('.drop-area').find('.file-desc')[0].innerHTML = `${file.name}`;
  $(this).closest(".drop-area").addClass('active');
});

$('.drop-area').on('dragover', function (event) {
  event.preventDefault();
  $(this).addClass('active')
  $(this).find('.file-desc').textContent = "Release to upload file";
});

$('.drop-area').on('dragleave', function (event) {
  event.preventDefault()

  if ($(this).find('.input-file')[0].files.length === 0) {
    $(this).find('.file-desc').innerHTML = "Drag and drop or click here <br>to upload image";

    $(this).removeClass('active');
  } else {
    $(this).find('.file-desc').innerHTML = `${inputFile.files[0].name}`;
  }
});

$('.drop-area').on('drop', function (event) {
  event.preventDefault()

  $(this).find('.input-file')[0].files = event.originalEvent.dataTransfer.files;

  $(this).find('.file-desc')[0].innerHTML = $(this).find('.input-file')[0].files[0].name;
});

$('.img-view').click(function (e) {
  e.preventDefault();

  $(this).siblings('.input-file').click()
});

//замена старой обложки на новую(пропадает старая,появляется новая)
function showImage(input) {
  const preview = document.getElementById("imagePreview");
  preview.style.display = "inline-block";
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (event) {
      // добавляем проверку на успешное чтение файла
      if (event.target.readyState === FileReader.DONE) {
        preview.src = event.target.result;
      }
    }
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = "";
    preview.style.display = "none";
  }
}
//модальное окно
function openModal(preview) {
  var modal = document.createElement('div');
  modal.classList.add('modal');
  //создаем кнопку для закрытия модального окна
  var closeButton = document.createElement('button');
  closeButton.classList.add('closeButton');
  closeButton.innerHTML = '&times;'; //добавляем символ крестика
  closeButton.onclick = function () {
    modal.remove();
  };
  var modalImg = document.createElement('img');
  modalImg.classList.add('modal-content');
  modalImg.src = document.getElementById('imagePreview').getAttribute('src');
  //добавляем кнопку в модальное окно перед картинкой
  modal.appendChild(closeButton);
  modal.appendChild(modalImg);
  document.body.appendChild(modal);
}

function openModal(img) {
  var modal = document.createElement('div');
  modal.classList.add('modal');
  var modalImg = document.createElement('img');
  modalImg.classList.add('modal-content');
  modalImg.src = img.src;
  modal.appendChild(modalImg);
  var closeButton = document.createElement('span');
  closeButton.classList.add('close');
  closeButton.innerHTML = '&times;';
  closeButton.onclick = function () {
    modal.remove();
  };
  modal.appendChild(closeButton);
  document.body.appendChild(modal);
  // Изменяем обработчик событий на клик только на элемент с классом .close для его закрытия
  closeButton.onclick = function (event) {
    modal.remove();
  }
}
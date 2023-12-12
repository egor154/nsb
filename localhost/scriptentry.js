function previewImage(input) {
  var preview = document.getElementById("preview");
  preview.style.display = "block";
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}

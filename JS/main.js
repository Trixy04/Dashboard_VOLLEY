function nascondiDIV(id) {
  if (document.getElementById(id).style.display == "block") {
    var required = "required";
    document.getElementById(id).style.display = "none";
  } else {
    var required = "required";
    document.getElementById(id).style.display = "block";
  }

  return required
}

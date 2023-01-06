const errorBox = document.getElementsByClassName("error")[0];
if (errorBox.textContent.trim() === "") {
    errorBox.setAttribute(`style`, `display: none;`);
}


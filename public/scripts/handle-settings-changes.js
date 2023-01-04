const emailButton = document.getElementById("email-btn");
const emailInput = emailButton.parentElement.getElementsByTagName("input")[0];

const validateEmail = ((event) => {
    const isValid = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(event.target.value);
    if (isValid) {
        emailButton.removeAttribute("disabled");
        emailInput.classList.remove("no-valid");
    } else {
        emailInput.classList.add("no-valid");
        emailButton.setAttribute("disabled", true);
    }
});

emailButton.addEventListener("click", () => {
    const inputStatus = emailInput.getAttribute("readonly");
    if (inputStatus !== null) {
        emailInput.removeAttribute("readOnly");
        emailButton.innerHTML = `Set new email`;
        emailButton.setAttribute("disabled", true);
        emailInput.addEventListener("focusout", validateEmail);
    }
    else {
        const email = emailInput.value;
        handleChangeEmail(email);
    }
});




const handleChangeEmail = (newEmail) => {
    const data = {
        email: newEmail
    }
    fetch("/emailChange", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then((response) => {
        return response.json();
    }).then((data) => {
        if(data.hasOwnProperty("message")) {
            throw new Error(data.message);
        }
        emailInput.setAttribute('placeholder', newEmail);
        emailInput.setAttribute('readonly', true);
        emailInput.setAttribute('value', "");
        emailInput.removeEventListener("focusout", validateEmail);
        emailButton.innerHTML = `Unlock input`;
    }).catch((message) => {
        alert(message.message);
    });
};
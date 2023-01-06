const emailButton = document.getElementById("email-btn");
const passwordButton = document.getElementById("password-btn");
const emailInput = emailButton.parentElement.getElementsByTagName("input")[0];
let favDialog = document.getElementById('alert-dialog');

const alertDialog = (alertMessage) => {
    const header = document.getElementById("dialog-header");
    const head = createTagWithOptions("h2", {innerText: `${alertMessage[0].toUpperCase()}${alertMessage.substr(1)}`});
    header.appendChild(head);
    const actionDiv = document.getElementById("dialog-actions");
    const cancelBtn = createTagWithOptions("button", {value: "cancel", id: "cacnel-btn"});
    cancelBtn.innerHTML = "Ok"
    actionDiv.appendChild(cancelBtn);

    favDialog.showModal();


    favDialog.addEventListener("close", () => {
        favDialog.innerHTML= "";
        createDialogEmptyContent();
    });
}

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
        const date = new Date();
        date.setTime(date.getTime() + (30*60*1000));
        let expires = "expires="+ date.toUTCString();
        document.cookie = "user-email" + "=" + newEmail + ";" + expires + ";path=/";
    }).catch((message) => {
        alertDialog(message.message);
    });
};

const handleChangePassword = (newPassword) => {
    const data = {
        password: newPassword
    }
    fetch("/passwordChange", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(() => {
        alertDialog("Password successfully changed");
    });
}

const createTagWithOptions = (tagName, options) => {
    return Object.assign(document.createElement(tagName),options);
}

const createDialogEmptyContent = () => {
    const dialog = document.getElementById("alert-dialog");

    const dialogForm = createTagWithOptions("form", {method: "dialog"});
    
    const divs = [
        createTagWithOptions("div", {id: "dialog-header"}),
        createTagWithOptions("div", {id: "dialog-content"}),
        createTagWithOptions("div", {id: "dialog-actions"}),
    ]
    
    dialogForm.append(...divs);
    
    dialog.appendChild(dialogForm);
}

createDialogEmptyContent();


const createDialogActionButtons = (buttonString) => {
    const actionDiv = document.getElementById("dialog-actions");
    const cancelBtn = createTagWithOptions("button", {value: "cancel", id: "cancel-btn"});
    cancelBtn.innerHTML = "Cancel"
    actionDiv.appendChild(cancelBtn);
    
    const confirmBtn = createTagWithOptions("button", {value: "default", id: "confirm-btn", disabled: true});
    confirmBtn.innerHTML = `Set ${buttonString}`;
    actionDiv.appendChild(confirmBtn);
} 

const addDialogHeaderString = (title) => {
    const header = document.getElementById("dialog-header");
    const head = createTagWithOptions("h2", {innerText: `Set new ${title}`});
    header.appendChild(head);
}

const createDialogInput = (name, placeholder, type, id = "dialog-input") => {
    const label = createTagWithOptions("label", {for: name});
    label.innerHTML = `${name[0].toUpperCase()}${name.substr(1)}`;
    const input = createTagWithOptions("input", {name: name, type: type, placeholder: placeholder, value: "", id: id});
    const dialogContent = document.getElementById("dialog-content");
    dialogContent.appendChild(label);
    dialogContent.appendChild(input);
}

const createEmailChangeContext = () => {
    addDialogHeaderString("email");
    createDialogInput("email", "newmail@exmaple.com", "email");
    createDialogActionButtons("email");

    const confirmBtn = document.getElementById("confirm-btn");
    const input = document.getElementById("dialog-input");
    const validateEmail = ((event) => {
        const isValid = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(event.target.value);
        if (isValid) {
            confirmBtn.removeAttribute("disabled");
            input.classList.remove("no-valid");
        } else {
            input.classList.add("no-valid");
            confirmBtn.setAttribute("disabled", true);
        }
    });

    input.addEventListener("focusout", validateEmail);
    confirmBtn.addEventListener('click', (e) => {
        confirmBtn.value = document.getElementById("dialog-input").value;
    });

    favDialog.addEventListener('close', () => {
        favDialog.innerHTML= "";
        createDialogEmptyContent();
        if (!["cancel", "default"].includes(favDialog?.returnValue)) {
            handleChangeEmail(favDialog.returnValue);
        }
        const dialogClone = favDialog.cloneNode(true);
        favDialog.remove();
        favDialog = dialogClone;
        document.body.appendChild(favDialog);
    });
}


const createPasswordChangeContext = () => {
    addDialogHeaderString("password");
    createDialogInput("password", "password", "password", "passwd-input");
    createDialogInput("Password reapeat", "password", "password", "repeat-passwd-input");
    createDialogActionButtons("password");

    const confirmBtn = document.getElementById("confirm-btn");
    const passwordInput = document.getElementById("passwd-input");
    const repeatedPasswordInput = document.getElementById("repeat-passwd-input");
    let repeatedPasswordTouched = false;
    let repeatedPasswordValid = false;
    let passwordValid = false;

    const changeErrorClass = (input, isValid) => {
        !isValid ? input.classList.add("no-valid") : input.classList.remove("no-valid");
    }
    
    const updateButtonState = () => {
        repeatedPasswordValid && passwordValid ? confirmBtn.removeAttribute("disabled") : confirmBtn.setAttribute("disabled", true);
    };

    const validatePassword = ((event) => {
        const isValid = /\w{3,}/.test(event.target.value);
        passwordValid = isValid;
        changeErrorClass(event.target, isValid);
        updateButtonState();
        validateReapetedPassword();
    });    
    
    const validateReapetedPassword = ((event) => {
        if(event === undefined && repeatedPasswordTouched === false) {
            return false;
        }
        repeatedPasswordTouched = true;
        const isValid = passwordInput.value === repeatedPasswordInput.value;
        repeatedPasswordValid = isValid;
        changeErrorClass(event.target, isValid);
        updateButtonState();
    });

   passwordInput.addEventListener("focusout", validatePassword);
   repeatedPasswordInput.addEventListener("focusout", validateReapetedPassword);


    confirmBtn.addEventListener('click', (e) => {
        confirmBtn.value = document.getElementById("passwd-input").value;
    });

    favDialog.addEventListener('close', () => {
        favDialog.innerHTML= "";
        createDialogEmptyContent();
        if (!["cancel", "default"].includes(favDialog?.returnValue)) {
            handleChangePassword(favDialog.returnValue);
        }
        const dialogClone = favDialog.cloneNode(true);
        favDialog.remove();
        favDialog = dialogClone;
        document.body.appendChild(favDialog);
    });
}


emailButton.addEventListener("click", () => {
    createEmailChangeContext();
    favDialog.showModal();
});

passwordButton.addEventListener("click", () => {
    createPasswordChangeContext();
    favDialog.showModal();
});

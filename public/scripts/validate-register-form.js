const formInputs = Array(...document.getElementsByTagName("input"))
                .reduce((acc, input) => {
                    acc[input.name] = input;
                    return acc;
                }, {});

const submitButton = document.querySelector('div.login-form button');
submitButton.setAttribute("disabled", "");

const formState = {valid: false, controls: {}};


const validateEmail = ((event) => {
    const isValid = /\w+@\w+.\w+/.test(event.target.value);
    updateFormState("email", isValid);
});


const validateLogin = ((event) => {
    const isValid = /\w{3,}/.test(event.target.value);
    updateFormState("login", isValid);
});


const validatePassword = ((event) => {
    const isValid = /\w{3,}/.test(event.target.value);
    updateFormState("password", isValid);
    validateReapetedPassword();
});


const validateReapetedPassword = ((event) => {
    const isValid = formInputs["password"].value === formInputs["password-repeat"].value;
    updateFormState("password-repeat", isValid);
});

const setFormState = () => {
    const formValid = Object.values(formState.controls).find((valid) => valid.state === false);
    formValid === undefined ? formState.valid = true : formState.valid = false;
    formState.valid ? submitButton.removeAttribute("disabled") : submitButton.setAttribute("disabled", "");
}

const updateFormState = (control, valid) => {
    formState.controls[control] = {state: valid};
    setFormState();
    changeErrorClass(formInputs[control], valid);
};

const changeErrorClass = (input, isValid) => {
    !isValid ? input.classList.add("no-valid") : input.classList.remove("no-valid");
}

const fieldValidators = {
    "email": validateEmail,
    "login": validateLogin,
    "password": validatePassword,
    "password-repeat": validateReapetedPassword
};


Object.values(formInputs).forEach((input) => {
    formState.controls[input.name] = {state: false };
    input.addEventListener("focusout", fieldValidators[input.name]);
});

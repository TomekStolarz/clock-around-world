let favDialog = document.getElementById('alert-dialog');

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
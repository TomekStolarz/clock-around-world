const historyButtons = Array.from(document.getElementsByClassName("history"));
const deletionButtons = Array.from(document.getElementsByClassName("deletion"));


const createHisoryDialog = (historyData) => {
    const header = document.getElementById("dialog-header");
    const head = createTagWithOptions(
        "h2", 
        {
            innerText: `${historyData.user.login[0].toUpperCase()}${historyData.user.login.substring(1)} history`
        }
    );
    header.appendChild(head);

    const contentDiv = document.getElementById("dialog-content");
    contentDiv.classList.add("history");

    const history = historyData.history.map((history) => {
        const historyRow = createTagWithOptions("div", {classList: "history-row"})
        historyRow.appendChild(
            createTagWithOptions(
                "div", 
                { 
                    classList: "history-col",
                    innerText: `${history.action}`
                }
            )
        );

        historyRow.appendChild(
            createTagWithOptions(
                "div", 
                { 
                    classList: "history-col",
                    innerText: `${history.time.substring(0, history.time.lastIndexOf("."))}`
                }
            )
        );
        return historyRow;
    });

    contentDiv.append(...history);

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

const deleteUser = (userId, userRow) => {
    fetch("/userDelete", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id_user: userId})
    }).then(() => {
        alertDialog("User successfully deleted");
        userRow.remove();
    })
}

const userHistory = (userId) => {
    fetch("/userHistory", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id_user: userId})
    }).then((response) => 
        response.json()
    ).then((data) => {
        createHisoryDialog(data);
    })
}

deletionButtons.forEach((button) => {
    const userRow = button.parentElement.parentElement;
    const userDiv = userRow.firstElementChild;
    const userId = parseInt(userDiv.getAttribute("data-id"));
    button.addEventListener("click", () => deleteUser(userId, userRow));
})

historyButtons.forEach((button) => {
    const userDiv = button.parentElement.parentElement.firstElementChild;
    const userId = parseInt(userDiv.getAttribute("data-id"));
    button.addEventListener("click", () => userHistory(userId));
})

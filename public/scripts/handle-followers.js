const [buttonRemoveFollowers, buttonAddFollowers] = document.getElementsByTagName("button");
const cityId = buttonRemoveFollowers.parentElement.getAttribute("id");
let isFollowed = false;

const changeDisabledButtons = (isFollow) => {
    if(isFollow) {
        buttonAddFollowers.setAttribute("disabled", "true");
        buttonRemoveFollowers.removeAttribute("disabled");
        return;
    }
    buttonRemoveFollowers.setAttribute("disabled", "true");
    buttonAddFollowers.removeAttribute("disabled");
}

const data = {
    "id_city": cityId
};

fetch("/isFollowed", {
    method: "POST",
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
}).then((response) => {
    return response.json();
}).then((response) => {
    isFollowed = response.isFollowed;
    changeDisabledButtons(isFollowed);
});


buttonAddFollowers.addEventListener("click", () => {
    fetch(`/follow/${cityId}`).then( () => {
        isFollowed = true;
        changeDisabledButtons(isFollowed);
    });
})

buttonRemoveFollowers.addEventListener("click", () => {
    fetch(`/unfollow/${cityId}`).then( () => {
        isFollowed = false;
        changeDisabledButtons(isFollowed);
    });
})

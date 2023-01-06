const timeColumn = Array.from(document.getElementsByClassName("col-value")).pop();


const  getTime = (currentTime, timezone) =>{
    return currentTime.toLocaleTimeString("pl", {timeZone: timezone ?? "Europe/London" });
}

timeColumn.innerHTML = getTime(currentTime, timezone);

const subscription = currentTime$.subscribe({ next: (time) => {timeColumn.innerHTML = getTime(time, timezone)} });

window.onbeforeunload  = () => {subscription.unsubscribe()};






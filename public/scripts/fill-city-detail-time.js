class Observable {
    constructor(exec) {
        this.listeners = new Set;
        exec({
            next: (value) => this.listeners.forEach(({next}) => next && next(value)),
            error: (err) => this.listeners.forEach(({error}) => error && error(err)),
            complete: () => this.listeners.forEach(({complete}) => complete && complete())
        });
    }
    subscribe(listeners) {
        this.listeners.add(listeners);
        return { unsubscribe: () => this.listeners.delete(listeners) }
    }
}

const currentTime$ = new Observable(({next}) => {
    setInterval(() => next(new Date()), 1000);
});


const timeColumn = Array.from(document.getElementsByClassName("col-value")).pop();


const  getTime = (currentTime, timezone) =>{
    return currentTime.toLocaleTimeString("pl", {timeZone: timezone ?? "Europe/London" });
}

const subscription = currentTime$.subscribe({ next: (time) => {timeColumn.innerHTML = getTime(time, timezone)} });

window.onbeforeunload  = () => {subscription.unsubscribe()};






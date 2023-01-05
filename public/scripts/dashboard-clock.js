let userLocation;

const getLocation = () => {
    if (!navigator.geolocation)
      return;
      
    let _location;
    navigator.geolocation.getCurrentPosition((position) => {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      findCityByCoord(lat, lng);
    })
  }

const findCityByCoord = async (latitude, longitude) =>  {
    let cityMapping;
    await fetch("/allCities").then((respnse) => {
        return respnse.json();
    }).then((data) => {
        cityMapping = [...data];
    });

    userLocation = cityMapping.map(city => {
      return {
        cityData: city,
        accuracy: Math.abs(city.latitude - latitude) + Math.abs(city.longitude - longitude)
      }
    }).sort((first, second) => first.accuracy - second.accuracy)[0].cityData;

    document.getElementsByClassName("clock-title")[0].innerHTML = `Time at ${userLocation.city}`;
};

getLocation();

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

const currentTime = new Date();

const currentTime$ = new Observable(({next}) => {
    setInterval(() => next(new Date()), 1000);
});


const timeColumn = Array.from(document.getElementsByClassName("col-value")).pop();


const  getTime = (currentTime, timezone) =>{
    return currentTime.toLocaleTimeString("pl", {timeZone: timezone ?? "Europe/London" });
}

const fillClock = (time) => {
    const clockTiles = Array.from(document.getElementsByClassName("number-tile"));
    const digitsTime = time.split("").filter((x) => /\d/.test(x)).join("");
    let shift = 0;
    if (clockTiles.length != digitsTime.length) {
        shift = clockTiles.length - digitsTime.length;
    }
    clockTiles.slice(0, shift).forEach((elem) => {
        elem.innerHTML = 0;
        elem.setAttribute("data-value", 0);
    });
    
    animateNumbers(
        clockTiles.slice(shift)
        .map((elem, index) => {
            return {
                tile: elem, 
                index: index
            }
        })
        .filter((x, index) => x.tile.getAttribute("data-value") !== digitsTime[index]),
        digitsTime,
        shift
    );
}

const animateNumbers  = (elems, digitsTime, shift) => {
    const starts = elems.map((elem) => {
        let val = elem.tile.getAttribute("data-rotationX") ?? 0;
        val = typeof(val) === "string" ? parseInt(val) : val;
        val = val >= 360 ? 0 : val === 0 ? 0 : 180;
        return val;
    } );

    let counter = 0;
    let joined = false;

    let timer = setInterval(() => {
        positions = [];
        counter += 3;
        
        positions = starts.map((start) => `rotateX(${start + counter}deg)`);

        if (counter  >= 90) {
            positions = starts.map((start) => `rotateX(${start + counter}deg) rotateZ(${start + 180}deg) rotateY(${start + 180}deg)`);
            if(!joined) {
                elems.forEach((x) => {
                    x.tile.innerHTML = digitsTime[x.index];
                    x.tile.setAttribute("data-value", digitsTime[x.index]);
                });
            }
        }
        if (counter == 183) {
            clearInterval(timer);
            return;
        }

        animate(elems, positions, starts, counter);
    }, 8);
}

const animate = (tiles, positions, starts, degs) => {
    tiles.forEach((elem, index) => {
        elem.tile.style.transform = positions[index];
        elem.tile.setAttribute("data-rotationX", degs + starts[index]);
    })  
};

fillClock(getTime(currentTime, userLocation?.timezone));

const subscription = currentTime$.subscribe({ next: (time) => {fillClock(getTime(time, userLocation?.timezone))} });

window.onbeforeunload  = () => {subscription.unsubscribe()};
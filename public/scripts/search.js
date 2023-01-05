const search = document.querySelector('input[name="search"]');
const cityContainer = document.querySelector(".records");
const tableLabel = document.querySelector(".table-label");

search.addEventListener("keyup", (event) => {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: event.target.value};

        fetch("/searchCities", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(
            (response) => response.json()
         ).then((cities) => {
            tableLabel.innerHTML = `Founded ${cities.length} cities`;
            cityContainer.innerHTML = "";
            createCities(cities)
        });
    }
});

const createCities = (cities) => {
    cities.forEach((city) => {
        createCity(city);
    });
}

const createCity = (city) => {
    const row = document.createElement("a");
    row.setAttribute("class", "row");
    row.setAttribute("href", `public/citydetail/${city.id_city}`)

    const cityCol = document.createElement("div");
    cityCol.innerHTML = city.city;

    const countryCol = document.createElement("div");
    countryCol.innerHTML = city.country;
    
    row.append(cityCol, countryCol);

    cityContainer.appendChild(row);
}

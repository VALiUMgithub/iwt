document.addEventListener("DOMContentLoaded", function () {
  // Function to make an Ajax request to the RapidAPI weather service
  function getWeatherData(city) {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === 4) {
        if (this.status === 200) {
          // Parse the JSON response
          const response = JSON.parse(this.responseText);

          // Access the weather data from the response
          const temperature = response.current.temp_c;
          const description = response.current.condition.text;

          // Display weather data on the webpage
          const weatherInfo = document.getElementById("weather-info");
          const weatherHtml = `
              <h2>Weather Information</h2>
              <p>Temperature: ${temperature} °C</p>
              <p>Description: ${description}</p>
            `;

          weatherInfo.innerHTML = weatherHtml;
        } else {
          console.error("Error:", this.status, this.statusText);
          const weatherInfo = document.getElementById("weather-info");
          weatherInfo.innerHTML = "<p>Unable to fetch weather data.</p>";
        }
      }
    });

    // Get the city name from the input field
    const cityInput = document.getElementById("city-input").value;

    xhr.open(
      "GET",
      `https://weatherapi-com.p.rapidapi.com/current.json?q=${cityInput}`
    );
    xhr.setRequestHeader(
      "X-RapidAPI-Key",
      "ec2fcee8c7msh702d8c06913b533p138ec2jsn710c54e9ad8b"
    );
    xhr.setRequestHeader("X-RapidAPI-Host", "weatherapi-com.p.rapidapi.com");

    xhr.send();
  }

  // Get weather data when the button is clicked
  const getWeatherButton = document.getElementById("get-weather-button");
  getWeatherButton.addEventListener("click", getWeatherData);
});

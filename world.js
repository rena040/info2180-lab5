document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookupCities'); // New button
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');

    // Function to perform AJAX request
    function fetchData(lookupType) {
        const country = countryInput.value.trim();

        const xhr = new XMLHttpRequest();
        let url;

        // If no country is entered, fetch all countries
        if (!country) {
            url = `world.php?lookup=${lookupType}`; // Fetch all countries or cities
        } else {
            url = `world.php?country=${encodeURIComponent(country)}&lookup=${lookupType}`;
        }

        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText; // Insert the data into the result div
            } else {
                resultDiv.innerHTML = 'Error fetching data.';
            }
        };

        xhr.onerror = function() {
            resultDiv.innerHTML = 'Request failed.';
        };

        xhr.send(); // Send the request
    }

    // Event listener for Lookup button
    lookupButton.addEventListener('click', () => {
        fetchData('countries'); // Indicate we want country data
    });

    // Event listener for Lookup Cities button
    lookupCitiesButton.addEventListener('click', () => {
        fetchData('cities'); // Indicate we want city data
    });
});
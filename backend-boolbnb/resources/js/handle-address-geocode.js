/* -----------------------------------------
* HANDLE ADDRESS GEOCODE
-------------------------------------------*/

//*** FUNCTIONS ***//

/**
 * Throttle API Request for address geocode
 * 
 * @param {String} addressTerm 
 */
const searchPlace = addressTerm => {

    // Show loader inside suggestions list
    suggestionsElem.innerHTML = '<li class="pe-none"><i class="fas fa-spinner fa-pulse text-danger p-3"></i></li>';
    suggestionsElem.classList.add('show');

    // Handle API throttling
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        fetchApi(addressTerm);
    }, 500);
}

/**
 * Fetch Tom Tom Geocode API
 * 
 * @param {String} query 
 */
const fetchApi = query => {

    // Abort if query is empty
    if (!query) {
        // Resets
        addressInput.value = '';
        latInput.value = null;
        lonInput.value = null;

        suggestionsElem.classList.remove('show');
        suggestionsElem.innerHTML = '';
        return;
    }

    // Geocode API Call
    axios.get(baseUri + query + '.json', {
        params: baseParams,
        transformRequest: sanitizeHeaders
    })
        .then(res => {

            // Get Results
            const { results } = res.data;
            if (!results.length) return;

            // Create suggestions list
            suggestionsElem.innerHTML = '';
            results.forEach(result => {
                // Get palce data
                const palce = {
                    address: result.address.freeformAddress,
                    lat: result.position.lat,
                    lon: result.position.lon
                };

                // Add place to suggestions
                suggestionsElem.innerHTML += `<li class="suggestions-item py-2" data-lat="${palce.lat}" data-lon="${palce.lon}">${palce.address}</li>`;
            });

        })
        .catch(err => {
            console.log(err);
            // Show error message
            suggestionsElem.innerHTML = '<li class="text-danger pe-none p-3">Impossibile contattare il server</li>';
        });
}


//*** INIT ***//
// dom
const addressSearchInput = document.getElementById('address-search');
const suggestionsElem = document.getElementById('api-suggestions');
const addressInput = document.getElementById('address');
const latInput = document.getElementById('latitude');
const lonInput = document.getElementById('longitude');

// api
const baseUri = 'https://api.tomtom.com/search/2/geocode/';
const baseParams = {
    key: import.meta.env.VITE_TT_API_KEY,// API KEY
    limit: 5,
    language: 'it-IT',
    countrySet: 'IT'
};
const sanitizeHeaders = [(data, headers) => {
    delete headers.common["X-Requested-With"];
    return data
}];

// variables
let timeoutId = null;


//*** LOGIC ***//
// Handle search input keyup
addressSearchInput.addEventListener('keyup', () => {

    // Get Input Value
    const addressTerm = addressSearchInput.value.trim();

    // Fetch TT API with throttling (bypass "Too many requests" error)
    searchPlace(addressTerm);
});

// Handle suggestions visibility
addressSearchInput.addEventListener('focusout', () => {
    suggestionsElem.classList.remove('show');
});

// Handle suggestions list click
suggestionsElem.addEventListener('click', (e) => {
    // Get list item clicked
    const suggestion = e.target;

    // Check if is a suggestions list item
    if (!suggestion.classList.contains('suggestions-item')) return

    // Set values
    addressInput.value = suggestion.innerText;
    latInput.value = suggestion.dataset.lat;
    lonInput.value = suggestion.dataset.lon;

    // Set search input value
    addressSearchInput.value = suggestion.innerText;
});

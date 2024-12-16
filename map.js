let map;
let service;
let directionsService;
let directionsRenderer;
let autocomplete;

function initMap() {
    // Initialize the map centered on a default location
    const center = { lat: 37.7749, lng: -122.4194 }; // San Francisco, CA as a default center
    map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 14
    });

    // Initialize directions service and renderer
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Initialize the autocomplete for search functionality
    const input = document.getElementById('search');
    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
}

function searchLocation() {
    const place = autocomplete.getPlace();

    if (!place.geometry) {
        window.alert("No details available for input: '" + place.name + "'");
        return;
    }

    // Center the map to the searched location
    map.setCenter(place.geometry.location);
    map.setZoom(15);
}

function calculateRoute() {
    const start = autocomplete.getPlace();
    if (!start || !start.geometry) {
        window.alert("Please search and select a starting location first.");
        return;
    }

    const end = prompt("Enter destination address or place:");
    if (!end) return;

    directionsService.route(
        {
            origin: start.geometry.location,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING,
        },
        (response, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(response);

                // Calculate the total duration and distance
                const route = response.routes[0];
                let totalDuration = 0;
                let totalDistance = 0;
                route.legs.forEach(leg => {
                    totalDuration += leg.duration.value; // duration in seconds
                    totalDistance += leg.distance.value; // distance in meters
                });

                // Convert duration to minutes
                totalDuration = Math.round(totalDuration / 60);
                alert(`Total Distance: ${totalDistance / 1000} km, Duration: ${totalDuration} min`);
            } else {
                window.alert("Directions request failed due to " + status);
            }
        }
    );
}

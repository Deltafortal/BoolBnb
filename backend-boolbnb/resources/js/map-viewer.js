/* -----------------------------------------
* MAP VIEWER
-------------------------------------------*/
import tt from "@tomtom-international/web-sdk-maps"

const mapButton = document.getElementById('map-button');

mapButton.addEventListener('click', ()=>{

    // INIT
    const mapContainer = document.getElementById('map');
    
    if (mapContainer) {
        
        const lat = mapContainer.dataset.latitude;
        const lon = mapContainer.dataset.longitude;
        
        const map = tt.map({
            key: import.meta.env.VITE_TT_API_KEY,
            container: mapContainer,
            center: [
                lon,
                lat
            ],
            zoom: 12
        });
        map.addControl(new tt.NavigationControl());
        
        const marker = new tt.Marker().setLngLat([lon, lat]).addTo(map);
    }
})
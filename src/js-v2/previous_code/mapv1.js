// Map configuration constants
const MAP_CONFIG = {
    center: [10.3157, 123.8854],
    defaultZoom: 9,
    maxZoom: 19,
    minZoom: 5
};

const TILE_LAYERS = {
    light: {
        url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        options: {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }
    },
    dark: {
        // Using Stadia Maps Dark theme for better dark mode appearance
        url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png',
        options: {
            attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
        }
    }
};

class MarkerManager {
    constructor(map) {
        this.map = map;
        this.markers = new Map();
    }

    addMarker(id, latlng, popupContent) {
        if (!this.markers.has(id)) {
            const marker = L.marker(latlng)
                .bindPopup(popupContent)
                .addTo(this.map);
            this.markers.set(id, marker);
        }
    }

    removeMarker(id) {
        if (this.markers.has(id)) {
            const marker = this.markers.get(id);
            marker.remove();
            this.markers.delete(id);
        }
    }

    updateMarkersVisibility(zoomLevel) {
        if (zoomLevel >= 8) {
            this.addMarker(
                'stNino',
                [10.2936, 123.8952],
                '<b>St. Niño Church</b><br>A famous historical church in Cebu.'
            );
        } else {
            this.removeMarker('stNino');
        }
    }
}

class ThemeManager {
    constructor(map, layers) {
        this.map = map;
        this.layers = layers;
        this.currentTheme = 'light';
    }

    toggleTheme() {
        const toggleButton = document.getElementById("toggleButton");
        const sidebar = document.querySelector('#sidebar');

        if (this.currentTheme === 'light') {
            this.map.removeLayer(this.layers.light);
            this.layers.dark.addTo(this.map);
            this.currentTheme = 'dark';
            toggleButton.textContent = "View in Light Mode";
            document.body.classList.add('dark-mode');
            // this.updateSidebarDarkMode(sidebar, true);
        } else {
            this.map.removeLayer(this.layers.dark);
            this.layers.light.addTo(this.map);
            this.currentTheme = 'light';
            toggleButton.textContent = "View in Dark Mode";
            document.body.classList.remove('dark-mode');
            // this.updateSidebarDarkMode(sidebar, false);
        }
    }

    updateSidebarDarkMode(sidebar, isDark) {
        if (isDark) {
            sidebar.classList.remove('bg-white', 'text-primary-600');
            sidebar.classList.add('bg-gray-800', 'text-white');
            
            const listItems = sidebar.querySelectorAll('li');
            listItems.forEach(item => {
                item.classList.add('hover:bg-gray-700');
                item.classList.remove('hover:bg-primary-500');
            });
        } else {
            sidebar.classList.add('bg-white', 'text-primary-600');
            sidebar.classList.remove('bg-gray-800', 'text-white');
            
            const listItems = sidebar.querySelectorAll('li');
            listItems.forEach(item => {
                item.classList.remove('hover:bg-gray-700');
                item.classList.add('hover:bg-primary-500');
            });
        }
    }
}

class MapController {
    constructor() {
        this.map = this.initializeMap();
        this.layers = this.initializeLayers();
        this.markerManager = new MarkerManager(this.map);
        this.themeManager = new ThemeManager(this.map, this.layers);
        this.setupEventListeners();
        this.markerManager.updateMarkersVisibility(this.map.getZoom());
    }

    initializeMap() {
        const map = L.map("map", { 
            zoomControl: false 
        }).setView(MAP_CONFIG.center, MAP_CONFIG.defaultZoom);

        L.control.zoom({
            position: "bottomright"
        }).addTo(map);

        return map;
    }

    initializeLayers() {
        const lightLayer = L.tileLayer(
            TILE_LAYERS.light.url,
            {
                ...TILE_LAYERS.light.options,
                maxZoom: MAP_CONFIG.maxZoom
            }
        ).addTo(this.map);


        const darkLayer = L.tileLayer(
            TILE_LAYERS.dark.url,
            {
                ...TILE_LAYERS.dark.options,
                maxZoom: MAP_CONFIG.maxZoom
            }
        );

        return {
            light: lightLayer,
            dark: darkLayer
        };
    }

    setupEventListeners() {
        this.map.on("zoomend", () => {
            const zoomLevel = this.map.getZoom();
            this.markerManager.updateMarkersVisibility(zoomLevel);
        });

        const toggleButton = document.getElementById("toggleButton");
        toggleButton.addEventListener("click", () => this.themeManager.toggleTheme());
    }
}

// Initialize the map controller
const mapController = new MapController();

// Map configuration constants and defaults
const MAP_CONFIG = {
  center: [10.3157, 123.8854],
  defaultZoom: 9,
  maxZoom: 19,
  minZoom: 5,
};

//Tile configuration constants and map themes
// light_all,
// dark_all,
// light_nolabels,
// light_only_labels,
// dark_nolabels,
// dark_only_labels,
// rastertiles/voyager,
// rastertiles/voyager_nolabels,
// rastertiles/voyager_only_labels,
// rastertiles/voyager_labels_under
const TILE_LAYERS = {
  light: {
    url: "https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png",
    options: {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    },
  },
  dark: {
    // Using Stadia Maps Dark theme for better dark mode appearance
    url: "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png",
    options: {
      attribution:
        '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
    },
  },
};

// Icons for different classifications
const classificationIcons = {
  NationalCulturalTreasures: L.icon({
    iconUrl: "assets/icons/NationalCulturalTreasure--PIN.png",
    iconSize: [50, 50],
  }),
  NationalHistoricalShrines: L.icon({
    iconUrl: "assets/icons/NationalHistoricalShrine--PIN.png",
    iconSize: [50, 50],
  }),
  NationalHistoricalLandmarks: L.icon({
    iconUrl: "assets/icons/NationalHistoricalLandmark--PIN.png",
    iconSize: [50, 50],
  }),
  NationalHistoricalMonuments: L.icon({
    iconUrl: "assets/icons/NationalHistoricalMonument--PIN.png",
    iconSize: [50, 50],
  }),
  ClassifiedHistoricStructures: L.icon({
    iconUrl: "assets/icons/ClassifiedHistoricStructure--PIN.png",
    iconSize: [50, 50],
  }),
  ImportantCulturalProperties: L.icon({
    iconUrl: "assets/icons/ImportantCulturalProperty--PIN.png",
    iconSize: [50, 50],
  }),
  PresumedImportantCulturalProperties: L.icon({
    iconUrl: "assets/icons/PresumedImportantCP--PIN.png",
    iconSize: [50, 50],
  }),
  UNESCOWorldHeritageSites: L.icon({
    iconUrl: "assets/icons/UNESCO--PIN.png",
    iconSize: [50, 50],
  }),
  LocalCulturalProperties: L.icon({
    iconUrl: "assets/icons/LocalCulturalProperty--PIN.png",
    iconSize: [50, 50],
  }),
  RegisteredProperties: L.icon({
    iconUrl: "assets/icons/RegisteredProperty--PIN.png",
    iconSize: [50, 50],
  }),
  HistoricalMarker: L.icon({
    iconUrl: "assets/icons/HistoricalMarker_Pin_a.png",
    iconSize: [50, 50],
  }),
};

const fetchMapDetails = async (type) => {
  try {
    const response = await fetch(`backend/api/${type}-map-details.php`);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
};

// Fetch NCP/LSS data

const fetchData = async (ncpID, type) => {
  try {
    const response = await fetch(
      `backend/api/all-properties.php?id=${ncpID}&type=${type}`,
      {
        method: "GET",
      }
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Failed to connect to the API", error.message);
  }
};

// Create popup content for NCP

async function createPopupContent(feature, ncpID, userID) {
  console.log("Creating popup content for NCP", ncpID);
  let sanitizedID = Number(String(ncpID).replace(/\D/g, ""));
  const results = await fetchData(sanitizedID, "ncp");
  const propertyDetails = { ...results[0] };

  return `

    <table>
        <tr>
            <td><strong>${feature.properties["Property Name"]}</strong></td>
        </tr>
        ${
          propertyDetails.ncpofficialname
            ? `<tr><td><br/><strong>Official Name:</strong><br/>${propertyDetails.ncpofficialname}</td></tr>`
            : ""
        }
        ${
          propertyDetails.ncpclassificationstatus
            ? `<tr><td><strong>Classification Status:</strong><br/>${propertyDetails.ncpclassificationstatus}</td></tr>`
            : ""
        }
        ${
          propertyDetails.ncptownorcity
            ? `<tr><td><strong>Town/City:</strong><br/>${propertyDetails.ncptownorcity}</td></tr>`
            : ""
        }
        ${
          propertyDetails.ncpyeardeclared
            ? `<tr><td><strong>Year Declared:</strong><br/>${propertyDetails.ncpyeardeclared}</td></tr>`
            : ""
        }
        ${
          propertyDetails.ncptownorcity && propertyDetails.areaid
            ? `<tr><td><br/><a href='galleries?area=${propertyDetails.ncptownorcity.toLowerCase()}&areaid=${
                propertyDetails.areaid
              }&id=${sanitizedID}&type=ncpid'>More info...</a></td></tr>`
            : ""
        }
    </table>
    `;
}

// Popup function for LatLonNCP_10

async function pop_LatLonNCP_10(feature, layer) {
  const ncpID = feature.properties["ID"];
  const userID = "<?php echo $userid; ?>"; // Ensure this is set correctly

  layer.on({
    click: async function (e) {
      const popupContent = await createPopupContent(feature, ncpID, userID);
      layer.bindPopup(popupContent, { maxHeight: 400 }).openPopup();
    },
  });
  layer.bindPopup("", { maxHeight: 400 });
}

// Create popup content for Local Significant Sites

async function createPopupContentLSS(feature, ossID, userID) {
  // let sanitizedID = Number(ossID.replace(/\D/g, ""));
  let sanitizedID = Number(String(ossID).replace(/\D/g, ""));
  const result = await fetchData(sanitizedID, "lcp");
  const propertyDetails = { ...result[0] };
  return `

    <table>
        <tr>
            <td colspan="2"><strong>${
              feature.properties["Property Name"]
            }</strong></td>
        </tr>
        ${
          propertyDetails.lssofficialname
            ? `<tr><td colspan="2"><br><strong>Official Name:</strong><br/>${propertyDetails.lssofficialname}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lssfilipinoname
            ? `<tr><td colspan="2"><strong>Filipino Name:</strong><br/>${propertyDetails.lssfilipinoname}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lsslocalname
            ? `<tr><td colspan="2"><strong>Local Name:</strong><br/>${propertyDetails.lsslocalname}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lssclassificationstatus
            ? `<tr><td colspan="2"><strong>Classification Status:</strong><br/>${propertyDetails.lssclassificationstatus}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lsstownorcity
            ? `<tr><td colspan="2"><strong>Town/City:</strong><br/>${propertyDetails.lsstownorcity}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lssyeardeclared
            ? `<tr><td colspan="2"><strong>Year Declared:</strong><br/>${propertyDetails.lssyeardeclared}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lssotherdeclarations
            ? `<tr><td colspan="2"><strong>Other Declarations:</strong><br/>${propertyDetails.lssotherdeclarations}</td></tr>`
            : ""
        }
        ${
          propertyDetails.lsslegislation
            ? `<tr><td colspan="2"><strong>Legislation:</strong><br/>${propertyDetails.lsslegislation}</td></tr>`
            : ""
        }
        <tr>
            <td><br/><a href='galleries?area=${propertyDetails.lsstownorcity.toLowerCase()}&areaid=${
    propertyDetails.areaid || "None"
  }&id=${sanitizedID}&type=lcpid'>More info...</a></td>
        </tr>
    </table>
    `;
}

// Popup function for LatLonLocalSignificantSites_0

function pop_LatLonLocalSignificantSites_0(feature, layer) {
  var ossID = feature.properties["ID"];
  var userID = "<?php echo $user_id; ?>"; // Ensure this is set correctly

  layer.on({
    click: async function (e) {
      const popupContent = await createPopupContentLSS(feature, ossID, userID);
      layer.bindPopup(popupContent, { maxHeight: 400 }).openPopup();
    },
  });
  layer.bindPopup("", { maxHeight: 400 });
}

class MarkerManager {
  constructor(map) {
    this.map = map;
    this.markers = new Map();
  }

  addMarker(id, latlng, popupContent) {
    if (!this.markers.has(id)) {
      const marker = L.marker(latlng).bindPopup(popupContent).addTo(this.map);
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
    //No code for now
    // if (zoomLevel >= 8) {
    //   this.addMarker(
    //     "stNino",
    //     [10.2936, 123.8952],
    //     "<b>St. Niño Church</b><br>A famous historical church in Cebu."
    //   );
    // } else {
    //   this.removeMarker("stNino");
    // }
  }
}

class ThemeManager {
  constructor(map, layers) {
    this.map = map;
    this.layers = layers;
    this.currentTheme = "light";
  }

  toggleTheme() {
    const toggleButton = document.getElementById("toggleButton");
    const sidebar = document.querySelector("#sidebar");

    if (this.currentTheme === "light") {
      this.map.removeLayer(this.layers.light);
      this.layers.dark.addTo(this.map);
      this.currentTheme = "dark";
      toggleButton.textContent = "View in Light Mode";
      document.body.classList.add("dark-mode");
      // this.updateSidebarDarkMode(sidebar, true);
    } else {
      this.map.removeLayer(this.layers.dark);
      this.layers.light.addTo(this.map);
      this.currentTheme = "light";
      toggleButton.textContent = "View in Dark Mode";
      document.body.classList.remove("dark-mode");
      // this.updateSidebarDarkMode(sidebar, false);
    }
  }

  updateSidebarDarkMode(sidebar, isDark) {
    if (isDark) {
      sidebar.classList.remove("bg-white", "text-primary-600");
      sidebar.classList.add("bg-gray-800", "text-white");

      const listItems = sidebar.querySelectorAll("li");
      listItems.forEach((item) => {
        item.classList.add("hover:bg-gray-700");
        item.classList.remove("hover:bg-primary-500");
      });
    } else {
      sidebar.classList.add("bg-white", "text-primary-600");
      sidebar.classList.remove("bg-gray-800", "text-white");

      const listItems = sidebar.querySelectorAll("li");
      listItems.forEach((item) => {
        item.classList.remove("hover:bg-gray-700");
        item.classList.add("hover:bg-primary-500");
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
    this.geoJsonLayers = {};
    this.setupEventListeners();
    this.markerManager.updateMarkersVisibility(this.map.getZoom());
    this.loadGeoJsonLayers();
  }

  initializeMap() {
    const map = L.map("map", {
      zoomControl: false,
    }).setView(MAP_CONFIG.center, MAP_CONFIG.defaultZoom);

    L.control
      .zoom({
        position: "bottomright",
      })
      .addTo(map);

    return map;
  }

  initializeLayers() {
    const lightLayer = L.tileLayer(TILE_LAYERS.light.url, {
      ...TILE_LAYERS.light.options,
      maxZoom: MAP_CONFIG.maxZoom,
    }).addTo(this.map);

    const darkLayer = L.tileLayer(TILE_LAYERS.dark.url, {
      ...TILE_LAYERS.dark.options,
      maxZoom: MAP_CONFIG.maxZoom,
    });

    return {
      light: lightLayer,
      dark: darkLayer,
    };
  }

  async loadGeoJsonLayers() {
    // Fetch GeoJSON data
    const json_LatLonLocalSignificantSites_0 = await fetchMapDetails("lcp");
    const json_LatLonNCP_10 = await fetchMapDetails("ncp");
    // Add GeoJSON layers to the map
    this.addGeoJsonLayer(
      json_LatLonLocalSignificantSites_0,
      "Local Significant Sites",
      pop_LatLonLocalSignificantSites_0
    );
    this.addGeoJsonLayer(json_LatLonNCP_10, "NCP", pop_LatLonNCP_10);
  }

  addGeoJsonLayer(geoJsonData, layerName, popupFunction) {
    const geoJsonLayer = L.geoJSON(geoJsonData, {
      onEachFeature: (feature, layer) => {
        // Call the popup function for each feature
        popupFunction(feature, layer);
      },
      pointToLayer: (feature, latlng) => {
        // Get the classification from the feature properties
        const classification = feature.properties.classification;

        // Get the appropriate icon from the classificationIcons object
        const icon =
          classificationIcons[classification] ||
          L.icon({
            iconUrl: "assets/icons/default-icon.png", // Fallback icon
            iconSize: [50, 50],
          });

        // Return a marker with the custom icon
        return L.marker(latlng, { icon: icon });
      },
      style: (feature) => {
        return {
          color: feature.properties.color || "#3388ff", // Default color
          weight: 2,
          opacity: 1,
          fillOpacity: 0.5,
        };
      },
    }).addTo(this.map);
    this.geoJsonLayers[layerName] = geoJsonLayer; // Store the layer for future reference
  }

  setupEventListeners() {
    this.map.on("zoomend", () => {
      const zoomLevel = this.map.getZoom();
      this.markerManager.updateMarkersVisibility(zoomLevel);
    });

    const toggleButton = document.getElementById("toggleButton");
    toggleButton.addEventListener("click", () =>
      this.themeManager.toggleTheme()
    );
  }
}

// Initialize the map controller
const mapController = new MapController();

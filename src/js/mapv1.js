document.addEventListener("DOMContentLoaded", async () => {
  try {
    // Map configuration constants and defaults
    const MAP_CONFIG = {
      center: [10.3157, 123.8854],
      defaultZoom: 9,
      maxZoom: 19,
      minZoom: 5,
    };

    const TILE_LAYERS = {
      light: {
        url: "https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png",
        options: {
          attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        },
      },
      dark: {
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

    async function createPopupContent(feature, ncpID, userID) {
      console.log("Creating popup content for NCP", ncpID);
      const sanitizedID = Number(String(ncpID).replace(/\D/g, ""));
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

    async function pop_LatLonNCP_10(feature, layer) {
      const ncpID = feature.properties["ID"];
      const userID = "<?php echo $userid; ?>"; // Ensure this is set correctly

      layer.on({
        click: async (e) => {
          const popupContent = await createPopupContent(feature, ncpID, userID);
          layer.bindPopup(popupContent, { maxHeight: 400 }).openPopup();
        },
      });
      layer.bindPopup("", { maxHeight: 400 });
    }

    async function createPopupContentLSS(feature, ossID, userID) {
      const sanitizedID = Number(String(ossID).replace(/\D/g, ""));
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

    function pop_LatLonLocalSignificantSites_0(feature, layer) {
      var ossID = feature.properties["ID"];
      var userID = "<?php echo $user_id; ?>"; // Ensure this is set correctly

      layer.on({
        click: async (e) => {
          const popupContent = await createPopupContentLSS(
            feature,
            ossID,
            userID
          );
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
        // Implement zoom-based visibility logic here if needed
      }
    }

    class ThemeManager {
      constructor(map, layers) {
        this.map = map;
        this.layers = layers;
        this.currentTheme = "light";
      }

      toggleTheme() {
        //Disable toggle map dark mode
        // const toggleButton = document.getElementById("toggleButton");
        const sidebar = document.querySelector("#sidebar");

        if (this.currentTheme === "light") {
          this.map.removeLayer(this.layers.light);
          this.layers.dark.addTo(this.map);
          this.currentTheme = "dark";
          toggleButton.textContent = "View in Light Mode";
          document.body.classList.add("dark-mode");
        } else {
          this.map.removeLayer(this.layers.dark);
          this.layers.light.addTo(this.map);
          this.currentTheme = "light";
          toggleButton.textContent = "View in Dark Mode";
          document.body.classList.remove("dark-mode");
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
        const json_LatLonLocalSignificantSites_0 = await fetchMapDetails("lcp");
        const json_LatLonNCP_10 = await fetchMapDetails("ncp");

        this.geoJsonLayers["LatLonLocalSignificantSites_0"] =
          this.addGeoJsonLayer(
            json_LatLonLocalSignificantSites_0,
            "LatLonLocalSignificantSites_0",
            pop_LatLonLocalSignificantSites_0
          );

        this.geoJsonLayers["LatLonNCP_10"] = this.addGeoJsonLayer(
          json_LatLonNCP_10,
          "LatLonNCP_10",
          pop_LatLonNCP_10
        );
      }

      addGeoJsonLayer(geoJsonData, layerName, popupFunction) {
        const geoJsonLayer = L.geoJSON(geoJsonData, {
          onEachFeature: (feature, layer) => {
            popupFunction(feature, layer);
          },
          pointToLayer: (feature, latlng) => {
            const classification = feature.properties.classification;
            const icon =
              classificationIcons[classification] ||
              L.icon({
                iconUrl: "assets/icons/default-icon.png",
                iconSize: [50, 50],
              });
            return L.marker(latlng, { icon: icon });
          },
          style: (feature) => {
            return {
              color: feature.properties.color || "#3388ff",
              weight: 2,
              opacity: 1,
              fillOpacity: 0.5,
            };
          },
        });
        this.geoJsonLayers[layerName] = geoJsonLayer;
        return geoJsonLayer; // Return the layer so we can decide when to add it to the map
      }

      setupEventListeners() {
        this.map.on("zoomend", () => {
          const zoomLevel = this.map.getZoom();
          this.markerManager.updateMarkersVisibility(zoomLevel);
        });
        //Disable toggle map dark mode
        // const toggleButton = document.getElementById("toggleButton");
        // toggleButton.addEventListener("click", () =>
        //   this.themeManager.toggleTheme()
        // );
      }
    }

    const mapController = new MapController();
    await mapController.loadGeoJsonLayers();

    const ncpLayer = mapController.geoJsonLayers["LatLonNCP_10"];
    const lcpLayer =
      mapController.geoJsonLayers["LatLonLocalSignificantSites_0"];

    const ncpCheckbox = document.getElementById("nationalCulturalCheckbox");
    const lcpCheckbox = document.getElementById("localCulturalCheckbox");

    const ncpCategories = [
      document.getElementById("NationalCulturalTreasures"),
      document.getElementById("ImportantCulturalProperties"),
      document.getElementById("NationalHistoricalShrines"),
      document.getElementById("NationalHistoricalLandmarks"),
      document.getElementById("NationalHistoricalMonuments"),
      document.getElementById("ClassifiedHistoricStructures"),
      document.getElementById("UNESCOWorldHeritageSites"),
      document.getElementById("PresumedImportantCulturalProperties"),
      document.getElementById("HistoricalMarker"),
    ];

    const lcpCategories = [
      document.getElementById("LocalCulturalProperties"),
      document.getElementById("RegisteredProperties"),
    ];

    function toggleMarkersByClassification(layer, classification, isChecked) {
      layer.eachLayer((marker) => {
        if (
          marker.feature &&
          marker.feature.properties &&
          marker.feature.properties.classification === classification
        ) {
          if (isChecked) {
            mapController.map.addLayer(marker);
          } else {
            mapController.map.removeLayer(marker);
          }
        }
      });
    }

    // Event listeners for NCP categories
    ncpCategories.forEach((category) => {
      if (category) {
        category.addEventListener("change", function () {
          const isChecked = this.checked;
          const classification = this.id;
          toggleMarkersByClassification(ncpLayer, classification, isChecked);

          // Update the main NCP checkbox
          const allChecked = ncpCategories.every((cat) => cat && cat.checked);
          const someChecked = ncpCategories.some((cat) => cat && cat.checked);
          ncpCheckbox.checked = allChecked;
          ncpCheckbox.indeterminate = someChecked && !allChecked;

          // if (someChecked && !ncpLayer.isAddedToMap) {
          //   mapController.map.addLayer(ncpLayer);
          //   ncpLayer.isAddedToMap = true;
          // } else if (!someChecked && ncpLayer.isAddedToMap) {
          //   mapController.map.removeLayer(ncpLayer);
          //   ncpLayer.isAddedToMap = false;
          // }
          // Keep the layer, but update visible markers dynamically
          ncpLayer.eachLayer((marker) => {
            const markerClass = marker.feature?.properties?.classification;
            if (someChecked) {
              markerClass &&
                (ncpCategories.some(
                  (cat) => cat.checked && cat.id === markerClass
                )
                  ? mapController.map.addLayer(marker)
                  : mapController.map.removeLayer(marker));
            } else {
              // If nothing is checked, remove all markers but keep the layer
              mapController.map.removeLayer(marker);
            }
          });
        });
      }
    });

    // Event listeners for LCP categories
    lcpCategories.forEach((category) => {
      if (category) {
        category.addEventListener("change", function () {
          const isChecked = this.checked;
          const classification = this.id;
          toggleMarkersByClassification(lcpLayer, classification, isChecked);

          // Update the main LCP checkbox
          const allChecked = lcpCategories.every((cat) => cat && cat.checked);
          const someChecked = lcpCategories.some((cat) => cat && cat.checked);
          lcpCheckbox.checked = allChecked;
          lcpCheckbox.indeterminate = someChecked && !allChecked;

          // Keep the layer, but update visible markers dynamically
          lcpLayer.eachLayer((marker) => {
            const markerClass = marker.feature?.properties?.classification;
            if (someChecked) {
              markerClass &&
                (lcpCategories.some(
                  (cat) => cat.checked && cat.id === markerClass
                )
                  ? mapController.map.addLayer(marker)
                  : mapController.map.removeLayer(marker));
            } else {
              // If nothing is checked, remove all markers but keep the layer
              mapController.map.removeLayer(marker);
            }
          });
        });
      }
    });

    // Event listener for the NCP checkbox
    ncpCheckbox.addEventListener("change", function () {
      const isChecked = this.checked;
      ncpCategories.forEach((category) => {
        if (category) {
          category.checked = isChecked;
          toggleMarkersByClassification(ncpLayer, category.id, isChecked);
        }
      });
      if (isChecked && !ncpLayer.isAddedToMap) {
        mapController.map.addLayer(ncpLayer);
        ncpLayer.isAddedToMap = true;
      } else if (!isChecked && ncpLayer.isAddedToMap) {
        mapController.map.removeLayer(ncpLayer);
        ncpLayer.isAddedToMap = false;
      }
    });

    // Event listener for the LCP checkbox
    lcpCheckbox.addEventListener("change", function () {
      const isChecked = this.checked;
      lcpCategories.forEach((category) => {
        if (category) {
          category.checked = isChecked;
          toggleMarkersByClassification(lcpLayer, category.id, isChecked);
        }
      });
      if (isChecked && !lcpLayer.isAddedToMap) {
        mapController.map.addLayer(lcpLayer);
        lcpLayer.isAddedToMap = true;
      } else if (!isChecked && lcpLayer.isAddedToMap) {
        mapController.map.removeLayer(lcpLayer);
        lcpLayer.isAddedToMap = false;
      }
    });

    function firstLoadCheckboxes() {
      // Uncheck all checkboxes and categories by default
      ncpCategories.forEach((category) => {
        if (category) {
          category.checked = false;
        }
      });
      lcpCategories.forEach((category) => {
        if (category) {
          category.checked = false;
        }
      });
      ncpCheckbox.checked = false;
      lcpCheckbox.checked = false;

      const type = localStorage.getItem("type");

      if (type === "ncp") {
        ncpCheckbox.checked = true;
        ncpCategories.forEach((category) => {
          if (category) {
            category.checked = true;
          }
        });
        mapController.map.addLayer(ncpLayer);
        ncpLayer.isAddedToMap = true;
      } else if (type === "lcp") {
        lcpCheckbox.checked = true;
        lcpCategories.forEach((category) => {
          if (category) {
            category.checked = true;
          }
        });
        mapController.map.addLayer(lcpLayer);
        lcpLayer.isAddedToMap = true;
      } else {
        // If no type is stored, check all categories and layers
        ncpCheckbox.checked = true;
        lcpCheckbox.checked = true;
        ncpCategories.forEach((category) => {
          if (category) {
            category.checked = true;
          }
        });
        lcpCategories.forEach((category) => {
          if (category) {
            category.checked = true;
          }
        });
        mapController.map.addLayer(ncpLayer);
        mapController.map.addLayer(lcpLayer);
        ncpLayer.isAddedToMap = true;
        lcpLayer.isAddedToMap = true;
      }
      // Clear the type from localStorage after init
      localStorage.removeItem("type");
    }

    firstLoadCheckboxes();
    ncpLayer.isAddedToMap = true;
    lcpLayer.isAddedToMap = true;
  } catch (error) {
    console.error("Error initializing the map:", error);
  } finally {
    document.getElementById("load").style.visibility = "hidden";
  }
});

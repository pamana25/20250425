document.addEventListener("DOMContentLoaded", async () => {
  document.getElementById("map").style.visibility = "hidden";
  try {
    // Initialize map
    const initialBounds = [
      [9.454764150185886, 122.26693580657533],
      [11.26895835018586, 125.41985695341543],
    ];
    // Expand bounds slightly for smoother panning
    const expandedBounds = [
      [9.0, 121.8], 
      [11.7, 125.8], 
    ];
    const map = L.map("map", {
      zoomControl: false,
      maxZoom: 28,
      minZoom: 8,
    }).fitBounds(initialBounds);

    L.control
      .zoom({
        position: "bottomright",
      })
      .addTo(map);

    const hash = new L.Hash(map);
    map.attributionControl.setPrefix(
      '<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>'
    );

    map.setZoom(8);
    map.panTo([10.358, 123.843]);

    const autolinker = new Autolinker({
      truncate: {
        length: 30,
        location: "smart",
      },
    });
    const bounds_group = new L.featureGroup([]);

    function setBounds() {
      // const bounds = map.getBounds();
      // map.setMaxBounds(expandedBounds);
    }
    map.on("moveend", () => {
      const visibleBounds = map.getBounds();
      map.setMaxBounds(visibleBounds.pad(0.2)); // Add flexibility for panning
    });

    map.whenReady(() => {
      map.setMaxBounds(expandedBounds); // Set relaxed bounds initially
    });

    const fetchMapDetails = async (type) => {
      try {
        const response = await fetch(`backend/api/${type}-map-details.php`);
        const data = await response.json();
        return data;
      } catch (error) {
        console.error(error);
      }
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

    // Layer definitions
    const layerDefinitions = [
      {
        id: "Water_1_0",
        zIndex: 400,
        style: {
          opacity: 1,
          color: "rgba(35,35,35,0.0)",
          dashArray: "",
          lineCap: "butt",
          lineJoin: "miter",
          weight: 1.0,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(223,238,248,1.0)",
          interactive: false,
        },
        data: json_Water_1_0,
      },
      {
        id: "Provinces_Selected_1",
        zIndex: 401,
        style: {
          stroke: false,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(154,205,214,0.4)",
          interactive: false,
        },
        data: json_Provinces_Selected_1,
      },
      {
        id: "Cebu_2",
        zIndex: 402,
        style: {
          stroke: false,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(92,176,207,1.0)",
          interactive: false,
        },
        data: json_Cebu_2,
      },
      {
        id: "HighwayTrunk_mod_3",
        zIndex: 403,
        style: {
          opacity: 1,
          color: "rgba(255,255,197,1.0)",
          dashArray: "",
          lineCap: "square",
          lineJoin: "bevel",
          weight: 1.0,
          fillOpacity: 0,
          interactive: false,
        },
        data: json_HighwayTrunk_mod_3,
      },
      {
        id: "HighwaySecondary_mod_4",
        zIndex: 404,
        style: {
          opacity: 1,
          color: "rgba(255,255,84,1.0)",
          dashArray: "",
          lineCap: "square",
          lineJoin: "bevel",
          weight: 1.0,
          fillOpacity: 0,
          interactive: false,
        },
        data: json_HighwaySecondary_mod_4,
      },
      {
        id: "HighwayPrimary_mod_5",
        zIndex: 405,
        style: {
          opacity: 1,
          color: "rgba(238,219,0,1.0)",
          dashArray: "",
          lineCap: "square",
          lineJoin: "bevel",
          weight: 1.0,
          fillOpacity: 0,
          interactive: false,
        },
        data: json_HighwayPrimary_mod_5,
      },
      {
        id: "NaturalWood_mod_6",
        zIndex: 406,
        style: {
          opacity: 1,
          color: "rgba(35,35,35,1.0)",
          dashArray: "",
          lineCap: "butt",
          lineJoin: "miter",
          weight: 1.0,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(114,155,111,1.0)",
          interactive: false,
        },
        data: json_NaturalWood_mod_6,
      },
      {
        id: "NaturalGrassland_7",
        zIndex: 407,
        style: {
          stroke: false,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(86,122,74,1.0)",
          interactive: false,
        },
        data: json_NaturalGrassland_7,
      },
      {
        id: "LeisurePark_mod_8",
        zIndex: 408,
        style: {
          opacity: 1,
          color: "rgba(35,35,35,1.0)",
          dashArray: "",
          lineCap: "butt",
          lineJoin: "miter",
          weight: 1.0,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(164,113,88,1.0)",
          interactive: false,
        },
        data: json_LeisurePark_mod_8,
      },
      {
        id: "LanduseForest_9",
        zIndex: 409,
        style: {
          stroke: false,
          fill: true,
          fillOpacity: 1,
          fillColor: "rgba(140,229,155,1.0)",
          interactive: false,
        },
        data: json_LanduseForest_9,
      },
      {
        id: "LatLonNCP_10",
        zIndex: 410,
        style: {
          rotationAngle: 0.0,
          rotationOrigin: "center center",
          icon: L.icon({
            iconUrl: "qgis/markers/blue-marker.svg",
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -25],
          }),
          interactive: true,
        },

        data: [],
        pointToLayer: function (feature, latlng) {
          const classification = feature.properties.classification;
          const icon = classificationIcons[classification] || this.style.icon;
          return L.marker(latlng, { ...this.style, icon: icon });
        },
        onEachFeature: pop_LatLonNCP_10,
      },
      {
        id: "LatLonLocalSignificantSites_0",
        zIndex: 411,
        style: {
          rotationAngle: 0.0,
          rotationOrigin: "center center",
          icon: L.icon({
            iconUrl: "pages/qgis/markers/blue-marker.svg",
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -25],
          }),
          interactive: true,
        },
        data: [],
        pointToLayer: function (feature, latlng) {
          const classification = feature.properties.classification;
          const icon = classificationIcons[classification] || this.style.icon;
          return L.marker(latlng, { ...this.style, icon: icon });
        },
        onEachFeature: pop_LatLonLocalSignificantSites_0,
      },
    ];

    // Create layers object to store references
    const layers = {};
    // Function to create and add layers
    async function createAndAddLayers() {
      const json_LatLonLocalSignificantSites_0 = await fetchMapDetails("lcp");
      const json_LatLonNCP_10 = await fetchMapDetails("ncp");

      console.log("lcp", json_LatLonLocalSignificantSites_0.features.length);
      console.log("ncp:", json_LatLonNCP_10.features.length);
      console.log(
        "total:",
        json_LatLonLocalSignificantSites_0.features.length +
          json_LatLonNCP_10.features.length
      );

      layerDefinitions.forEach((layerDef) => {
        map.createPane(`pane_${layerDef.id}`);
        map.getPane(`pane_${layerDef.id}`).style.zIndex = layerDef.zIndex;
        map.getPane(`pane_${layerDef.id}`).style["mix-blend-mode"] = "normal";

        if (layerDef.id === "LatLonLocalSignificantSites_0") {
          layerDef.data = json_LatLonLocalSignificantSites_0;
        }
        if (layerDef.id === "LatLonNCP_10") {
          layerDef.data = json_LatLonNCP_10;
        }

        const layer = new L.geoJson(layerDef.data, {
          attribution: "",
          interactive: layerDef.style.interactive,
          dataVar: `json_${layerDef.id}`,
          layerName: `layer_${layerDef.id}`,
          pane: `pane_${layerDef.id}`,
          onEachFeature: layerDef.onEachFeature || false,
          pointToLayer: layerDef.pointToLayer || null,
          style: layerDef.style,
        });

        bounds_group.addLayer(layer);
        // map.addLayer(layer);
        layers[layerDef.id] = layer;

        if (
          layerDef.id !== "LatLonNCP_10" &&
          layerDef.id !== "LatLonLocalSignificantSites_0"
        ) {
          map.addLayer(layer);
        }
      });
    }

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
        console.error("Failed to connect the api", error.message);
      }
    };

    // Create popup content
    async function createPopupContent(feature, ncpID, userID) {
      let sanitizedID = Number(ncpID.replace(/\D/g, ""));
      const results = await fetchData(sanitizedID, "ncp");
      const propertyDetails = { ...results[0] };

      return `
  <table>
    <tr>
      <td><strong>${
        feature.properties["Property Name"]
          ? autolinker.link(
              feature.properties["Property Name"].toLocaleString()
            )
          : ""
      }</strong></td>
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
      // console.log("THIS IS THE LAYER", feature);

      const ncpID =
        feature.properties["ID"] !== null
          ? autolinker.link(feature.properties["ID"].toLocaleString())
          : "";
      const userID = "<?php echo $userid; ?>";

      layer.on({
        click: async function (e) {
          const popupContent = await createPopupContent(feature, ncpID, userID);
          layer.setPopupContent(popupContent);
        },
      });

      layer.bindPopup("", {
        maxHeight: 400,
      });
    }

    // Popup function for LatLonLocalSignificantSites_0
    function pop_LatLonLocalSignificantSites_0(feature, layer) {
      var ossID =
        feature.properties["ID"] !== null
          ? autolinker.link(feature.properties["ID"].toLocaleString())
          : "";
      var userID = "<?php echo $user_id; ?>";

      layer.on({
        click: async function (e) {
          const popupContent = await createPopupContentLSS(
            feature,
            ossID,
            userID
          );
          layer.setPopupContent(popupContent);
        },
      });

      layer.bindPopup("", {
        maxHeight: 400,
      });
    }

    // Create popup content for Local Significant Sites
    async function createPopupContentLSS(
      feature,
      ossID,
      userID,
      classification
    ) {
      let sanitizedID = Number(ossID.replace(/\D/g, ""));
      const result = await fetchData(sanitizedID, "lcp");
      const propertyDetails = { ...result[0] };
      return `
  <table>
    <tr>
      <td colspan="2"><strong>${
        feature.properties["Property Name"]
          ? autolinker.link(
              feature.properties["Property Name"].toLocaleString()
            )
          : "None"
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

    // Initialize map
    await createAndAddLayers();
    setBounds();

    // Toggle functionality
    const ncpLayer = layers["LatLonNCP_10"];
    const lcpLayer = layers["LatLonLocalSignificantSites_0"];

    // Html Elements for NCP and LCP inputs
    const ncpCategories = [
      NationalCulturalTreasures,
      ImportantCulturalProperties,
      NationalHistoricalShrines,
      NationalHistoricalLandmarks,
      NationalHistoricalMonuments,
      ClassifiedHistoricStructures,
      UNESCOWorldHeritageSites,
      PresumedImportantCulturalProperties,
      HistoricalMarker,
    ];

    const lcpCategories = [LocalCulturalProperties, RegisteredProperties];

    // Event listener for the NCP button
    ncpCheckbox.addEventListener("change", function () {
      if (ncpCheckbox.checked) {
        ncpCategories.forEach((category) => {
          category.checked = true;
        });
        map.addLayer(ncpLayer);
      } else {
        map.removeLayer(ncpLayer);
      }
    });

    // Event listener for the LCP button
    lcpCheckbox.addEventListener("change", function () {
      if (lcpCheckbox.checked) {
        lcpCategories.forEach((category) => {
          category.checked = true;
        });
        map.addLayer(lcpLayer);
      } else {
        map.removeLayer(lcpLayer);
      }
    });

    function firstLoadCheckboxes() {
      // Uncheck all checkboxes and categories by default
      ncpCategories.forEach((category) => {
        category.checked = false;
      });
      lcpCategories.forEach((category) => {
        category.checked = false;
      });
      ncpCheckbox.checked = false;
      lcpCheckbox.checked = false;

      const type = localStorage.getItem("type");

      if (type === "ncp") {
        ncpCheckbox.checked = true;
        ncpCategories.forEach((category) => {
          category.checked = true;
        });
        map.addLayer(ncpLayer);
      } else if (type === "lcp") {
        lcpCheckbox.checked = true;
        lcpCategories.forEach((category) => {
          category.checked = true;
        });
        map.addLayer(lcpLayer);
      } else {
        // If no type is stored, check all categories and layers
        ncpCheckbox.checked = true;
        lcpCheckbox.checked = true;
        ncpCategories.forEach((category) => {
          category.checked = true;
        });
        lcpCategories.forEach((category) => {
          category.checked = true;
        });
        map.addLayer(ncpLayer);
        map.addLayer(lcpLayer);
      }
      // Clear the type from localStorage after init
      localStorage.removeItem("type");
    }

    firstLoadCheckboxes();
    function toggleMarkersByClassification(layer, classification, isChecked) {
      layer.eachLayer((marker) => {
        if (marker.feature.properties.classification === classification) {
          if (isChecked) {
            map.addLayer(marker);
          } else {
            map.removeLayer(marker);
          }
        }
      });
    }

    // Event listeners for NCP categories
    ncpCategories.forEach((category) => {
      category.addEventListener("change", function () {
        const isChecked = category.checked;
        const classification = category.id;
        toggleMarkersByClassification(ncpLayer, classification, isChecked);
      });
    });

    // Event listeners for LCP categories

    lcpCategories.forEach((category) => {
      category.addEventListener("change", function () {
        const isChecked = category.checked;
        const classification = category.id;
        toggleMarkersByClassification(lcpLayer, classification, isChecked);
      });
    });
  } catch (error) {
    console.error(error);
  } finally {
    document.getElementById("load").style.visibility = "hidden";
    document.getElementById("map").style.visibility = "visible";
  }
});
// });

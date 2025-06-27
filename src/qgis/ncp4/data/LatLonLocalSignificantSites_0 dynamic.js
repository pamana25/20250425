var json_LatLonLocalSignificantSites_0 = {
  type: "FeatureCollection",
  name: "LatLonLocalSignificantSites_0",
  crs: { type: "name", properties: { name: "urn:ogc:def:crs:OGC:1.3:CRS84" } },
  features: [],
};

fetch('backend/api/lcp-map-details.php')
  .then(response => response.json())
  .then(data => {
    json_LatLonLocalSignificantSites_0.features = data;
    document.dispatchEvent(new Event('geojsonDataLoaded')); // Dispatch event
  })
  .catch(error => {
    console.error('Error fetching data:', error);
  });

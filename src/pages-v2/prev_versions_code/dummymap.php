<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title>Pamana.org</title>
	<link rel="stylesheet" href="src/qgis/css/leaflet.css">
	<link rel="stylesheet" href="src/qgis/css/qgis2web.css">
	<link rel="stylesheet" href="src/qgis/css/fontawesome-all.min.css">
	<style>
		html,
		body {
			font-family: 'Arial', sans-serif;
			margin: 0;
			padding: 0;
		}

		body {
			width: 100%;
			height: calc(100vh - 45px);
		}

		#map {
			width: auto;
			height: 100%;
			box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
		}

		.map-wrapper {
			display: flex;
		}

		.map-column {
			width: auto;
			position: relative;
			height: 100%;
			padding: 15px;
		}

		.leaflet-popup-content {
			width: 400px;
			height: 170px;
			overflow-y: scroll;
		}

		#load {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			z-index: 10443;
		}

		#loader {
			border: 5px solid #3F80CD;
			border-top: 5px solid #f3f3f3;
			border-radius: 50%;
			width: 30px;
			height: 30px;
			animation: spin 2s linear infinite;
		}

		#loader label {
			color: #545454;
			font-family: Arial, Helvetica, sans-serif;
			margin-top: 50px;
			font-size: 11pt;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		@media screen and (max-width: 800px) {
			body {
				overflow-y: auto;
				overflow-x: hidden;
			}

			.map-wrapper {
				flex-direction: column;
				width: 100%;
			}

			.map-column {
				width: auto;
				height: 100vh;
				padding: 30px 15px 85px 15px;
			}
		}

		@media screen and (max-width: 600px) {
			.leaflet-left {
				left: 85%;
			}
		}

		@media screen and (max-width: 300px) {
			.leaflet-left {
				left: 80%;
			}

			.leaflet-popup-content {
				width: 100px !important;
			}

			.leaflet-popup-content table {
				font-size: 10px !important;
			}
		}
	</style>
</head>

<body>
	<div class="map-column">
		<div id="map"></div>
		<div id="load">
			<div id="loader"></div>
			<center><label>Loading...</label></center>
		</div>
		<div class="layer-toggle">
			<button id="toggleNCP">Toggle NCP</button>
			<button id="toggleLSS">Toggle Local Significant Sites</button>
		</div>
	</div>

	<script src="src/qgis/ncp4/js/qgis2web_expressions.js"></script>
	<script src="src/qgis/ncp4/js/leaflet.js"></script>
	<script src="src/qgis/ncp4/js/leaflet.rotatedMarker.js"></script>
	<script src="src/qgis/ncp4/js/leaflet.pattern.js"></script>
	<script src="src/qgis/ncp4/js/leaflet-hash.js"></script>
	<script src="src/qgis/ncp4/js/Autolinker.min.js"></script>
	<script src="src/qgis/ncp4/js/rbush.min.js"></script>
	<script src="src/qgis/ncp4/js/labelgun.min.js"></script>
	<script src="src/qgis/ncp4/js/labels.js"></script>
	<script src="src/qgis/ncp4/data/Water_1_0.js"></script>
	<script src="src/qgis/ncp4/data/Provinces_Selected_1.js"></script>
	<script src="src/qgis/ncp4/data/Cebu_2.js"></script>
	<script src="src/qgis/ncp4/data/HighwayTrunk_mod_3.js"></script>
	<script src="src/qgis/ncp4/data/HighwaySecondary_mod_4.js"></script>
	<script src="src/qgis/ncp4/data/HighwayPrimary_mod_5.js"></script>
	<script src="src/qgis/ncp4/data/NaturalWood_mod_6.js"></script>
	<script src="src/qgis/ncp4/data/NaturalGrassland_7.js"></script>
	<script src="src/qgis/ncp4/data/LeisurePark_mod_8.js"></script>
	<script src="src/qgis/ncp4/data/LanduseForest_9.js"></script>
	<script src="src/qgis/ncp4/data/LatLonNCP_10.js"></script>
	<script src="pages/qgis/ncp4/data/LatLonLocalSignificantSites_0.js"></script>
	<script>
		// Initialize map
		const map = L.map('map', {
			zoomControl: true,
			maxZoom: 28,
			minZoom: 8
		}).fitBounds([
			[9.454764150185886, 122.26693580657533],
			[11.26895835018586, 125.41985695341543]
		]);

		const hash = new L.Hash(map);
		map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');

		map.setZoom(9);
		map.panTo([10.3632, 123.8434]);

		const autolinker = new Autolinker({
			truncate: {
				length: 30,
				location: 'smart'
			}
		});
		const bounds_group = new L.featureGroup([]);

		function setBounds() {
			map.setMaxBounds(map.getBounds());
		}

		// Layer definitions
		const layerDefinitions = [{
				id: 'Water_1_0',
				zIndex: 400,
				style: {
					opacity: 1,
					color: 'rgba(35,35,35,0.0)',
					dashArray: '',
					lineCap: 'butt',
					lineJoin: 'miter',
					weight: 1.0,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(223,238,248,1.0)',
					interactive: false,
				},
				data: json_Water_1_0
			},
			{
				id: 'Provinces_Selected_1',
				zIndex: 401,
				style: {
					stroke: false,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(154,205,214,0.4)',
					interactive: false,
				},
				data: json_Provinces_Selected_1
			},
			{
				id: 'Cebu_2',
				zIndex: 402,
				style: {
					stroke: false,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(92,176,207,1.0)',
					interactive: false,
				},
				data: json_Cebu_2
			},
			{
				id: 'HighwayTrunk_mod_3',
				zIndex: 403,
				style: {
					opacity: 1,
					color: 'rgba(255,255,197,1.0)',
					dashArray: '',
					lineCap: 'square',
					lineJoin: 'bevel',
					weight: 1.0,
					fillOpacity: 0,
					interactive: false,
				},
				data: json_HighwayTrunk_mod_3
			},
			{
				id: 'HighwaySecondary_mod_4',
				zIndex: 404,
				style: {
					opacity: 1,
					color: 'rgba(255,255,84,1.0)',
					dashArray: '',
					lineCap: 'square',
					lineJoin: 'bevel',
					weight: 1.0,
					fillOpacity: 0,
					interactive: false,
				},
				data: json_HighwaySecondary_mod_4
			},
			{
				id: 'HighwayPrimary_mod_5',
				zIndex: 405,
				style: {
					opacity: 1,
					color: 'rgba(238,219,0,1.0)',
					dashArray: '',
					lineCap: 'square',
					lineJoin: 'bevel',
					weight: 1.0,
					fillOpacity: 0,
					interactive: false,
				},
				data: json_HighwayPrimary_mod_5
			},
			{
				id: 'NaturalWood_mod_6',
				zIndex: 406,
				style: {
					opacity: 1,
					color: 'rgba(35,35,35,1.0)',
					dashArray: '',
					lineCap: 'butt',
					lineJoin: 'miter',
					weight: 1.0,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(114,155,111,1.0)',
					interactive: false,
				},
				data: json_NaturalWood_mod_6
			},
			{
				id: 'NaturalGrassland_7',
				zIndex: 407,
				style: {
					stroke: false,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(86,122,74,1.0)',
					interactive: false,
				},
				data: json_NaturalGrassland_7
			},
			{
				id: 'LeisurePark_mod_8',
				zIndex: 408,
				style: {
					opacity: 1,
					color: 'rgba(35,35,35,1.0)',
					dashArray: '',
					lineCap: 'butt',
					lineJoin: 'miter',
					weight: 1.0,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(164,113,88,1.0)',
					interactive: false,
				},
				data: json_LeisurePark_mod_8
			},
			{
				id: 'LanduseForest_9',
				zIndex: 409,
				style: {
					stroke: false,
					fill: true,
					fillOpacity: 1,
					fillColor: 'rgba(140,229,155,1.0)',
					interactive: false,
				},
				data: json_LanduseForest_9
			},
			{
				id: 'LatLonNCP_10',
				zIndex: 410,
				style: {
					rotationAngle: 0.0,
					rotationOrigin: 'center center',
					icon: L.icon({
						iconUrl: 'qgis/markers/blue-marker.svg',
						iconSize: [50, 50],
						iconAnchor: [25, 50],
						popupAnchor: [0, -25]
					}),
					interactive: true,
				},
				data: json_LatLonNCP_10,
				pointToLayer: function(feature, latlng) {
					return L.marker(latlng, this.style);
				},
				onEachFeature: pop_LatLonNCP_10
			},
			{
				id: 'LatLonLocalSignificantSites_0',
				zIndex: 411,
				style: {
					rotationAngle: 0.0,
					rotationOrigin: 'center center',
					icon: L.icon({
						iconUrl: 'pages/qgis/markers/blue-marker.svg',
						iconSize: [50, 50],
						iconAnchor: [25, 50],
						popupAnchor: [0, -25]
					}),
					interactive: true,
				},
				data: json_LatLonLocalSignificantSites_0,
				pointToLayer: function(feature, latlng) {
					return L.marker(latlng, this.style);
				},
				onEachFeature: pop_LatLonLocalSignificantSites_0
			}
		];

		// Create layers object to store references
		const layers = {};

		// Function to create and add layers
		function createAndAddLayers() {
			layerDefinitions.forEach(layerDef => {
				map.createPane(`pane_${layerDef.id}`);
				map.getPane(`pane_${layerDef.id}`).style.zIndex = layerDef.zIndex;
				map.getPane(`pane_${layerDef.id}`).style['mix-blend-mode'] = 'normal';

				const layer = new L.geoJson(layerDef.data, {
					attribution: '',
					interactive: layerDef.style.interactive,
					dataVar: `json_${layerDef.id}`,
					layerName: `layer_${layerDef.id}`,
					pane: `pane_${layerDef.id}`,
					onEachFeature: layerDef.onEachFeature || false,
					pointToLayer: layerDef.pointToLayer || null,
					style: layerDef.style
				});

				bounds_group.addLayer(layer);
				map.addLayer(layer);
				layers[layerDef.id] = layer;
			});
		}

		// Fetch NCP data
		async function fetchNcpData(ncpID, userID) {
			const endpoints = [{
					url: 'src/qgis/get/getNcpOffNm.php',
					id: 'offNm'
				},
				{
					url: 'src/qgis/get/getNcpClassStat.php',
					id: 'classStat'
				},
				{
					url: 'src/qgis/get/getNcpTwnOrCty.php',
					id: 'townOrCity'
				},
				{
					url: 'src/qgis/get/getNcpYrDec.php',
					id: 'yrDec'
				},
				{
					url: 'src/qgis/get/getNcpLnk.php',
					id: 'lnkGal'
				}
			];

			const fetchPromises = endpoints.map(endpoint =>
				fetch(endpoint.url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: `query=${ncpID}${endpoint.id === 'lnkGal' ? `&query2=${userID}` : ''}`
				})
				.then(response => response.text())
				.then(data => ({
					id: endpoint.id,
					data
				}))
			);

			return Promise.all(fetchPromises);
		}

		// Create popup content
		async function createPopupContent(feature, ncpID, userID) {
			const results = await fetchNcpData(ncpID, userID);
			const contentMap = new Map(results.map(item => [item.id, item.data]));

			return `
        <table>
            <tr>
                <td><strong>${feature.properties['Property N'] !== null ? autolinker.link(feature.properties['Property N'].toLocaleString()) : ''}</strong></td>
            </tr>
            <tr><td><br/><strong>Official Name:</strong><br/>${contentMap.get('offNm')}</td></tr>
            <tr><td><strong>Classification Status:</strong><br/>${contentMap.get('classStat')}</td></tr>
            <tr><td><strong>Town/City:</strong><br/>${contentMap.get('townOrCity')}</td></tr>
            <tr><td><strong>Year Declared:</strong><br/>${contentMap.get('yrDec')}</td></tr>
            <tr><td><br/>${contentMap.get('lnkGal')}</td></tr>
        </table>
    `;
		}

		// Popup function for LatLonNCP_10
		function pop_LatLonNCP_10(feature, layer) {
			const ncpID = feature.properties['ID'] !== null ? autolinker.link(feature.properties['ID'].toLocaleString()) : '';
			const userID = "<?php echo $userid; ?>";

			layer.on({
				'click': async function(e) {
					const popupContent = await createPopupContent(feature, ncpID, userID);
					layer.setPopupContent(popupContent);
				}
			});

			layer.bindPopup('', {
				maxHeight: 400
			});
		}

		// Popup function for LatLonLocalSignificantSites_0
		function pop_LatLonLocalSignificantSites_0(feature, layer) {
			var ossID = feature.properties['ID'] !== null ? autolinker.link(feature.properties['ID'].toLocaleString()) : '';
			var userID = "<?php echo $user_id; ?>";

			layer.on({
				'click': async function(e) {
					const popupContent = await createPopupContentLSS(feature, ossID, userID);
					layer.setPopupContent(popupContent);
				}
			});

			layer.bindPopup('', {
				maxHeight: 400
			});
		}

		// Create popup content for Local Significant Sites
		async function createPopupContentLSS(feature, ossID, userID) {
			const endpoints = [{
					url: 'src/qgis/get/getOssOffNm.php',
					id: 'offNm'
				},
				{
					url: 'src/qgis/get/getOssFilNm.php',
					id: 'filNm'
				},
				{
					url: 'src/qgis/get/getOssLocNm.php',
					id: 'locNm'
				},
				{
					url: 'src/qgis/get/getOssClassStat.php',
					id: 'classStat'
				},
				{
					url: 'src/qgis/get/getOssTwnOrCty.php',
					id: 'townOrCity'
				},
				{
					url: 'src/qgis/get/getOssCatProv.php',
					id: 'prov'
				},
				{
					url: 'src/qgis/get/getOssCatReg.php',
					id: 'reg'
				},
				{
					url: 'src/qgis/get/getOssYrDec.php',
					id: 'yrDec'
				},
				{
					url: 'src/qgis/get/getOssOthDecs.php',
					id: 'othDecs'
				},
				{
					url: 'src/qgis/get/getOssLeg.php',
					id: 'leg'
				},
				{
					url: 'src/qgis/get/getOssLnk.php',
					id: 'lnkGal'
				}
			];

			const fetchPromises = endpoints.map(endpoint =>
				fetch(endpoint.url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: `query=${ossID}${endpoint.id === 'lnkGal' ? `&query2=${userID}` : ''}`
				})
				.then(response => response.text())
				.then(data => ({
					id: endpoint.id,
					data
				}))
			);

			const results = await Promise.all(fetchPromises);
			const contentMap = new Map(results.map(item => [item.id, item.data]));

			return `
        <table>
            <tr>
                <td colspan="2"><strong>${feature.properties['Property Name'] !== null ? autolinker.link(feature.properties['Property Name'].toLocaleString()) : ''}</strong></td>
            </tr>
            <tr><td colspan="2">${contentMap.get('offNm')}</td></tr>
            <tr><td colspan="2">${contentMap.get('filNm')}</td></tr>
            <tr><td colspan="2">${contentMap.get('locNm')}</td></tr>
            <tr><td colspan="2">${contentMap.get('classStat')}</td></tr>
            <tr><td colspan="2">${contentMap.get('townOrCity')}</td></tr>
            <tr><td colspan="2">${contentMap.get('prov')}</td></tr>
            <tr><td colspan="2">${contentMap.get('reg')}</td></tr>
            <tr><td colspan="2">${contentMap.get('yrDec')}</td></tr>
            <tr><td colspan="2">${contentMap.get('othDecs')}</td></tr>
            <tr><td colspan="2">${contentMap.get('leg')}</td></tr>
            <tr><td colspan="2">${contentMap.get('lnkGal')}</td></tr>
        </table>
    `;
		}

		// Initialize map
		createAndAddLayers();
		setBounds();

		// Toggle functionality
		document.getElementById('toggleNCP').addEventListener('click', function() {
			const layer = layers['LatLonNCP_10'];
			if (map.hasLayer(layer)) {
				map.removeLayer(layer);
			} else {
				map.addLayer(layer);
			}
		});

		document.getElementById('toggleLSS').addEventListener('click', function() {
			const layer = layers['LatLonLocalSignificantSites_0'];
			if (map.hasLayer(layer)) {
				map.removeLayer(layer);
			} else {
				map.addLayer(layer);
			}
		});

		// Loader
		document.addEventListener('readystatechange', function() {
			if (document.readyState === 'interactive') {
				document.getElementById('map').style.visibility = 'hidden';
			} else if (document.readyState === 'complete') {
				setTimeout(function() {
					document.getElementById('load').style.visibility = 'hidden';
					document.getElementById('map').style.visibility = 'visible';
				}, 1000);
			}
		});
	</script>
</body>

</html>
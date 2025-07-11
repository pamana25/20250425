//Metropolitan Cathedral and Parish Church of Saint Vitalis and of the Guardian Angels of Cebu

import * as THREE from "../../../library/three/build/three.module.js";
import { RoomEnvironment } from "../../../library/three/examples/jsm/environments/RoomEnvironment.js";
import { DRACOLoader } from "../../../library/three/examples/jsm/loaders/DRACOLoader.js";
import { GLTFLoader } from "../../../library/three/examples/jsm/loaders/GLTFLoader.js";
import { PointerLockControls } from "../../../library/three/examples/jsm/controls/PointerLockControls.js";
import { MapControls } from "../../../library/three/examples/jsm/controls/OrbitControls.js";
import { GUI } from "../../../library/three/examples/jsm/libs/lil-gui.module.min.js";
import Stats from "../../../library/three/examples/jsm/libs/stats.module.js";

//variables
let camera, scene, renderer, controls, stats, controlsmap, box;

const objects = [];
let currentControl;
let raycaster;
let movementSpeed = 100;
let moveForward = false;
let moveBackward = false;
let moveLeft = false;
let moveRight = false;
let canJump = false;
let char = null;
let objectHeight;
// let physicsWorld;

let prevTime = performance.now();
const velocity = new THREE.Vector3();
const direction = new THREE.Vector3();
const vertex = new THREE.Vector3();
const color = new THREE.Color();
const canvasWrapper = document.getElementById("canvas-wrapper");

//initialized
init();
//continue to animate
animate();

function init() {
  //camera
  camera = new THREE.PerspectiveCamera(
    60,
    window.innerWidth / window.innerHeight,
    1,
    1000
  );

  //scene
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xffffff);
  scene.fog = new THREE.Fog(0xffffff, 0, 750);

  //lighting
  const light = new THREE.HemisphereLight(0xeeeeff, 0x777788, 0.75);
  light.position.set(0.5, 1, 0.75);
  scene.add(light);

  //render
  renderer = new THREE.WebGLRenderer({ antialias: true });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(window.innerWidth, window.innerHeight);
  canvasWrapper.appendChild(renderer.domElement);

  //environment
  const environment = new RoomEnvironment();
  const pmremGenerator = new THREE.PMREMGenerator(renderer);
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xbbbbbb);
  scene.environment = pmremGenerator.fromScene(environment).texture;
  environment.dispose();

  //html elements
  const blocker = document.getElementById("blocker");
  const instructions = document.getElementById("instructions");
  const loadingscreen = document.getElementById("loading");
  const loadingmsg = document.getElementById("loading-msg");
  const modelVideo = document.getElementById("vid");

  //controller
  currentControl = "firstpersonctrl"; // or 'mapctrl'
  firstpersonctrl();

  const boxGeometry = new THREE.BoxGeometry(5, 5, 5);
  const boxMaterial = new THREE.MeshStandardMaterial({ color: 0xff0000 });
  box = new THREE.Mesh(boxGeometry, boxMaterial);
  scene.add(box);

  // Create a new GLTFLoader
  const loader = new GLTFLoader().setPath("../public/metropolitan_cathedral/");
  const dracoLoader = new DRACOLoader();
  loader.setDRACOLoader(dracoLoader);

  loadingscreen.style.display = "flex";
  loadingscreen.style.top = 0;
  // Create an array of GLB file paths
  const glbFiles = [
    "Bldg_B1_C1.gltf",
    "Bldg_B1_C2.gltf",
    "Bldg_B1_C3.gltf",
    "Bldg_B1_C4.gltf",
    "Bldg_B1_C5.gltf",
    "Bldg_B1_C6.gltf",
    "Bldg_B1_C7.gltf",
    "Bldg_B1_C8s.gltf",
    "Bldg_B2_C1.gltf",
    "Bldg_B3_C1s.gltf",
    "Bldg_B4_C1s.gltf",
    "Bldg_B5_C1s.gltf",
    "Bldg_B6_C1.gltf",
    "Bldg_B7_C1.gltf",
    "Bldg_B7_C2.gltf",
    "Bldg_B7_C3.gltf",
    "Bldg_B7_C4.gltf",
    "Bldg_B7_C5.gltf",
    "Bldg_B7_C6s.gltf",
    "Bldg_B7_C7.gltf",
    "Bldg_B7_C8s.gltf",
    "Bldg_B7_C9s.gltf",
    "Bldg_B8_C1s.gltf",
    "Bldg_B9_C1.gltf",
    "Bldg_B10_C1s.gltf",
    "Bldg_B10_C2s.gltf",
    "Bldg_B10_C3s.gltf",
    "Bldg_B11_C1.gltf",
    "Bldg_B12_C1.gltf",
    "Bldg_B13_C1s.gltf",
    "Bldg_B14_C1s.gltf",
    "Bldg_B15_C1s.gltf",
    "Bldg_B15_C2.gltf",
    "Block_2_Plaza_1.gltf",
    "Block_2_Plaza_2.gltf",
    "Block_2_Plaza_3.gltf",
    "Block_2_Plaza_4.gltf",
    "Block_2_Plaza_5.gltf",
    "Block_2_Plaza_6.gltf",
    "Block_2_Plaza_7.gltf",
    "Block_3_Colored.gltf",
    "Building_B1.gltf",
    "Building_B1a.gltf",
    "Building_B2.gltf",
    "Building_B3_Museum_A1.gltf",
    "Building_B3_Museum_A2.gltf",
    "Building_B3_Museum_A3.gltf",
    "Building_B3_Museum_A4.gltf",
    "Building_B3_Museum_F1.gltf",
    "Building_B3_Museum_F2.gltf",
    "Building_B3_Museum_F3.gltf",
    "Building_B3_Museum_F4.gltf",
    "Building_B3_Museum_F5.gltf",
    "Bell_Tower1.gltf",
    "Bell_Tower2.gltf",
    "Bell_Tower3.gltf",
    "Bell_Tower4.gltf",
    "Bell_Tower5.gltf",
    "Bell_Tower6.gltf",
    "Cathedral_1.gltf",
    "Cathedral_2.gltf",
    "Cathedral_3.gltf",
    "Cathedral_4.gltf",
    "Cathedral_5.gltf",
    "Cathedral_6.gltf",
    "Cathedral_7.gltf",
    "Cathedral_8.gltf",
    "Cathedral_8a.gltf",
    "Cathedral_9.gltf",
    "Cathedral_10.gltf",
    "Cathedral_11.gltf",
    "Cathedral_12.gltf",
    "Cathedral_13.gltf",
    "Cathedral_14.gltf",
    "Cathedral_block_1.gltf",
    "Cathedral_block_2.gltf",
    "Cathedral_block_3.gltf",
    "Cathedral_block_4.gltf",
  ];

  const seperateFiles = ["Road_Colored.gltf", "attached_building.gltf"];
  let loadPromise = Promise.resolve();

  // Load all files except for separateFiles
  glbFiles
    .filter((file) => !seperateFiles.includes(file))
    .forEach((file) => {
      loadPromise = loadPromise.then(() => {
        return new Promise((resolve) => {
          loadingmsg.innerHTML = "Loading resources " + file + "...";
          loader.load(file, function (gltf) {
            let mesh = gltf.scene;
            mesh.traverse(function (child) {
              if (child.isMesh) {
                objects.push(child);
              }
            });
            // const yOffset = -23; // Example vertical offset value
            // mesh.position.y += yOffset;
            scene.add(mesh);
            // render();
            resolve();
          });
        });
      });
    });

  // Load separateFiles
  seperateFiles.forEach((file) => {
    loadPromise = loadPromise.then(() => {
      return new Promise((resolve) => {
        loadingmsg.innerHTML = "Loading resources " + file + "...";
        loader.load(file, function (gltf) {
          // Do something special with separateFiles here
          let mesh = gltf.scene;
          //           const yOffset = -23; // Example vertical offset value
          // mesh.position.y += yOffset;
          scene.add(mesh);
          resolve();
        });
      });
    });
  });

  loadPromise
    .then(() => {
      // All GLB files have been loaded
      // Hide the loading animation
      loadingmsg.innerHTML = "Loading Complete.";
      setTimeout(() => {
        loadingscreen.style.display = "none";
        modelVideo.style.display = "none";
      }, 800);
    })
    .catch((error) => {
      console.error(error);
    });

  const guicontrol = {
    Home: function gohome() {
      window.open("./../", "_blank");
    },
    Stats: true,
    controlType: "FirstPersonControl",
    changeControlType: function () {
      if (guicontrol.controlType === "MapControl") {
        currentControl = "mapctrl";
        blocker.style.display = "none";
        mapctrl();
      } else {
        currentControl = "firstpersonctrl";
        blocker.style.display = "block";
        firstpersonctrl();
      }
    },
    reset: function newpos() {
      // camera.position.y = 10;
      camera.position.x = 10;
    },
  };

  // gui controls
  const gui = new GUI({ autoPlace: false });
  gui.domElement.style.position = "absolute";
  gui.domElement.style.top = "0px";
  gui.domElement.style.right = "15px";
  gui.domElement.style.zIndex = "12";
  canvasWrapper.appendChild(gui.domElement);

  gui.add(guicontrol, "Home");
  gui.add(guicontrol, "Stats").onChange((value) => {
    if (value == false) {
      stats.dom.style.display = "none";
    } else {
      stats.dom.style.display = "block";
    }
  });
  const folder = gui.addFolder("Camera Control Type");
  folder
    .add(guicontrol, "controlType", ["MapControl", "FirstPersonControl"])
    .name("Control Type")
    .onChange(function (value) {
      guicontrol.changeControlType();
    });

  gui.add(guicontrol, "reset").name("Unstuck(F1)");
  document.addEventListener("keydown", function (event) {
    if (event.code === "F1") {
      camera.position.x = 10;
    }
  });

  //stats
  stats = new Stats();
  stats.showPanel(0);
  canvasWrapper.appendChild(stats.domElement);
  stats.domElement.style.position = "absolute";

  window.addEventListener("resize", onWindowResize);
  getObjectHeight();
}

function onWindowResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();

  renderer.setSize(window.innerWidth, window.innerHeight);
}

//object height
function getObjectHeight() {
  for (let i = 0; i < objects.length; i++) {
    objectHeight = objects[i].geometry.boundingBox.max.y;
    // do something with objectHeight
  }
}

//animate
function animate() {
  requestAnimationFrame(animate);
  stats.update();
  // let ctrlupudate = controls.update();
  if (currentControl === "mapctrl") {
    mapcontrolUpdate();
  } else if (currentControl === "firstpersonctrl") {
    pointerlockcontrolsUpdate();
    box.position.copy(controls.getObject().position);
    box.rotation.copy(controls.getObject().rotation);
    // box.position.z += 10;
  }

  render();
}
// setInterval(function() {
//   console.log(camera.position);
// }, 1000);

function render() {
  renderer.render(scene, camera);
}

function mapcontrolUpdate() {
  controlsmap.update();
}

function pointerlockcontrolsUpdate() {
  const time = performance.now();
  var blocked = false;
  if (controls.isLocked === true) {
    var distance = 2; // distance from object
    var origin = new THREE.Vector3();
    origin.copy(box.position);
    origin.y += 0.5;
    const delta = (time - prevTime) / 1000;

    velocity.x -= velocity.x * 10.0 * delta;
    velocity.z -= velocity.z * 10.0 * delta;

    velocity.y -= 8 * 70.0 * delta; // 100.0 = mass
    // velocity.y -= 10 * 100.0 * delta; // 100.0 = mass

    direction.z = Number(moveForward) - Number(moveBackward);
    direction.x = Number(moveRight) - Number(moveLeft);
    direction.normalize(); // this ensures consistent movements in all directions

    if (moveForward || moveBackward)
      velocity.z -= direction.z * movementSpeed * delta;
    if (moveLeft || moveRight)
      velocity.x -= direction.x * movementSpeed * delta;

    // if (onObject === true) {
    //   velocity.y = Math.max(0, velocity.y);
    //   canJump = true;
    //   console.log("ok");
    // }

    controls.moveRight(-velocity.x * delta);
    controls.moveForward(-velocity.z * delta);

    controls.getObject().position.y += velocity.y * delta; // new behavior

    if (controls.getObject().position.y < 1.5) {
      velocity.y = 0;
      controls.getObject().position.y = 1.5;
      canJump = true;
    }
  }

  prevTime = time;
}

//map control
function mapctrl() {
  controlsmap = new MapControls(camera, renderer.domElement);

  //controls.addEventListener( 'change', render ); // call this only in static scenes (i.e., if there is no animation loop)
  if (
    !controlsmap.target.equals(
      new THREE.Vector3(
        194.98885052015652,
        131.805971772097,
        -63.40507998941366
      )
    )
  ) {
    controlsmap.target.set(
      194.98885052015652,
      131.805971772097,
      -63.40507998941366
    );
    camera.position.set(
      194.98885052015652,
      131.805971772097,
      -63.40507998941366
    );
  }
  controlsmap.enableDamping = true; // an animation loop is required when either damping or auto-rotation are enabled
  controlsmap.dampingFactor = 0.05;

  controlsmap.screenSpacePanning = false;

  controlsmap.minDistance = 100;
  controlsmap.maxDistance = 500;

  controlsmap.maxPolarAngle = Math.PI / 2;
}
// 54.24540438328149
//first person controls
function firstpersonctrl() {
  camera.position.set(236, 1, -86);

  controls = new PointerLockControls(camera, document.body);

  instructions.addEventListener("click", function () {
    controls.lock();
  });

  controls.addEventListener("lock", function () {
    instructions.style.display = "none";
    blocker.style.display = "none";
  });

  controls.addEventListener("unlock", function () {
    blocker.style.display = "block";
    instructions.style.display = "";
  });

  scene.add(controls.getObject());

  const onKeyDown = function (event) {
    switch (event.code) {
      case "ArrowUp":
      case "KeyW":
        moveForward = true;
        break;

      case "ArrowLeft":
      case "KeyA":
        moveLeft = true;
        break;

      case "ArrowDown":
      case "KeyS":
        moveBackward = true;
        break;

      case "ArrowRight":
      case "KeyD":
        moveRight = true;
        break;

      case "Space":
        if (canJump === true) velocity.y += 100;
        canJump = false;
        break;

      case "ShiftLeft":
      case "ShiftRight":
        movementSpeed = 50;
        break;
    }
  };

  const onKeyUp = function (event) {
    switch (event.code) {
      case "ArrowUp":
      case "KeyW":
        moveForward = false;
        break;

      case "ArrowLeft":
      case "KeyA":
        moveLeft = false;
        break;

      case "ArrowDown":
      case "KeyS":
        moveBackward = false;
        break;

      case "ArrowRight":
      case "KeyD":
        moveRight = false;
        break;
      case "ShiftLeft":
      case "ShiftRight":
        movementSpeed = 100;
        break;
    }
  };

  document.addEventListener("keydown", onKeyDown);
  document.addEventListener("keyup", onKeyUp);
}

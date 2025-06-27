const currentUrl = window.location.href;
const urlParams = new URLSearchParams(window.location.search);
let allProperties //all properties from LCP and NCP
let areaNameParams = urlParams.get("area");
let areaIdParams = urlParams.get("areaid");
document.addEventListener("DOMContentLoaded", async function () {
 

    const showLoadingIndicatorDiv = async () => {
      // Get the parent element
      const listProperties = document.getElementById("list-properties-loading");
      // Create the div element for the loading indicator
      const indicatorDiv = document.createElement('div');
      indicatorDiv.id = "loading-indicator";
      indicatorDiv.className = "absolute inset-0 flex items-center justify-center"; // Make the div cover the entire parent with flex centering
      // Define the loading indicator HTML
      const indicatorString = `
        <button type="button" class="bg-primary-500 text-white font-medium rounded-lg px-5 py-2.5 text-sm flex items-center" disabled>
          <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
          Loading...
        </button>
      `;
      // Add the indicator HTML to the div
      indicatorDiv.innerHTML = indicatorString;
      // Append the indicator div inside the parent element
      listProperties.appendChild(indicatorDiv);
      return indicatorDiv; 
    };
    const hideLoadingIndicatorDiv = () => {
      const div = document.querySelector('#loading-indicator');
      if (div) {
        div.remove();
      }
    };
    // api to get all ncp propertis
    const getNcpProperty = async () => {
      try {
        const response = await fetch(`backend/api/ncp.php`, {
          method: "GET",
        });
        if (!response.ok) {
          throw new Error("Failed to get Api data");
        }
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Failed to connect the api", error.message);
      }
    };
    const getNcpUploadedFile = async (ncpid) => {
      try {
        const response = await fetch(`backend/api/ncp.php?ncpid=${ncpid}`, {
          method: "GET",
        });
        if (!response.ok) {
          throw new Error("Failed to get Api data");
        }
        const data = await response.json();
        return data;
      } catch (error) {
        console.error("Failed to connect the api", error.message);
      }
    };

// Api to get the image by lssid
  const getLcpUploadedFile = async (lssid) => {
    try {
      const response = await fetch(`backend/api/lcp.php?lssid=${lssid}`, {
        method: "GET",
      });
      if (!response.ok) {
        throw new Error("Failed to get Api data");
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error("Failed to connect the api", error.message);
    }
  };
// api to get all the properties from LCP
  const getLcpProperty = async () => {
    try {
      const response = await fetch(`backend/api/lcp.php`, {
        method: "GET",
      });
      if (!response.ok) {
        throw new Error("Failed to get Api data");
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error("Failed to connect the api", error.message);
    }
  };
  // api to get all areas
  const getAllAreas = async () => {
    try {
      const response = await fetch(`backend/api/area.php`, {
        method: "GET",
      });
      if(!response.ok){
        throw new Error("Failed to get data from API")
      }
      const data = await response.json();
      return data; 
    } catch (error) {
      console.error("Failed to connect from API.")
    }
  };
    const ulAreas = document.getElementById("ul-areas");
    const areaData = await getAllAreas();
    const area = areaData
      .map((areaItem) => {
        return `
        <li class="location-pill">
          <button 
            data-area="${areaItem.areaname}" 
            data-areaid="${areaItem.areaid}" 
            class="capitalize bg-white ${areaNameParams == areaItem.areaname ? "bg-[#ef4444] border-0 text-white hover:bg-[#dc2626]": "text-gray-700"}  border border-gray-300 rounded-full px-3 py-1 text-sm font-medium hover:bg-gray-200"
            id="btnArea">
            ${areaItem.areaname}
          </button>
        </li>`;
      })
      .join("");
    ulAreas.innerHTML = area;
  const displayLcpSelectedProperty = async () => {
    if (areaNameParams && areaIdParams) {
      const lcpProperty = await getLcpProperty();
      const findLcpProperty = lcpProperty.filter(
        (lcp) => lcp.areaid == areaIdParams
      );
  
      if (findLcpProperty.length === 0) {
        return []; // No LCP properties found
      }
  
      const resultFoundLcpProperty = await Promise.all(
        findLcpProperty.map(async (res) => {
          const lssFile = await getLcpUploadedFile(res.lssid);
          if (res.uploadstatus === 1) {
            return `
              <article class="property-card  rounded-lg shadow bg-white flex flex-col">
                <img src="useruploads/lss/${lssFile ?? "no-photo.jpg"}" alt="${res.lssname}" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
                <div class="property-content p-4">
                  <a id="selectPropertyBtn" class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${res.lssname ?? ""}</a>
                  <div class="property-type text-sm text-gray-500">${res.lssclassificationstatus ?? ""}</div>
                </div>
              </article>`;

          }
          return null; // Return null if uploadstatus is not 1
        })
      );
  
      // Filter out null/undefined values and return only valid HTML strings
      return resultFoundLcpProperty.filter(Boolean);
    }
    return []; // If no areaName or areaId, return empty array
  };
  const displayNcpSelectedProperty = async () => {
    if (areaNameParams && areaIdParams) {
      const ncpProperty = await getNcpProperty();
      const findNcpProperty = ncpProperty.filter((ncp) => ncp.areaid == areaIdParams);
      if (findNcpProperty.length === 0) {
        return []; // No NCP properties found
      }
      const resultFoundNcpProperty = await Promise.all(
        findNcpProperty.map(async (ncp) => {
          const ncpFile = await getNcpUploadedFile(ncp.ncpid);
          if (ncp.uploadstatus === 1) {
            return `
            <article class="property-card rounded-lg shadow bg-white flex flex-col">
              <img src="useruploads/ncp/${ncpFile ?? "no-photo.jpg"}" alt="${ncp.ncpname}" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
              <div class="property-content p-4">
                <a id="selectPropertyBtn" class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${ncp.ncpname ?? ""}</a>
                <div class="property-type text-sm text-gray-500">${ncp.ncpclassificationstatus ?? ""}</div>
              </div>
            </article>
          `;

          }
          return null; // Return null if uploadstatus is not 1
        })
      );
      // Filter out null/undefined values and return only valid HTML strings
      return resultFoundNcpProperty.filter(Boolean);
    }
    return []; // If no areaName or areaId, return empty array
  };
  const displayNcpAndLcpData = async () => {
    showLoadingIndicatorDiv()
   try {
      const ncp = await displayNcpSelectedProperty(); // Get NCP data
      const lcp = await displayLcpSelectedProperty(); // Get LCP data
      const displayData = [...lcp, ...ncp];

      const listOfProperties = document.getElementById("list-properties-div");
      if(listOfProperties){
        if (displayData.length === 0) {
          // No data found for both LCP and NCP
          listOfProperties.innerHTML = `<div class="no-data">No properties found | select area above.</div>`;
          return;
        }
        // Join and display the valid HTML strings
        listOfProperties.innerHTML = displayData.join("");
      }


      const selectPropertyBtn = document.querySelectorAll('#selectPropertyBtn')
      if(selectPropertyBtn){
        selectPropertyBtn.forEach((btnProperty)=>{
          btnProperty.addEventListener('click', ()=>{
            console.log("btn is click")
            displaySelectedProperty()
          })
        })
      }


   } catch (error) {
      console.error("Something went wrong", error.message)
   }finally{
    hideLoadingIndicatorDiv()
   }
  };  
  displayNcpAndLcpData()

  

  const btnArea = document.querySelectorAll("#btnArea")
  btnArea.forEach((btn)=>{
    btn.addEventListener('click', (e)=>{
      
      const btnAreaid = e.target.getAttribute("data-areaid")
      const btnAreaname = e.target.getAttribute("data-area")

      // Parse the current URL
      const url = new URL(window.location.href);
      // displayAreas()
      
      areaNameParams = btnAreaname
      areaIdParams = btnAreaid
      // Update the query parameters
      url.searchParams.set('area', areaNameParams); 
      url.searchParams.set('areaid', areaIdParams); 

      window.history.replaceState({}, '', url);
      
      displayNcpAndLcpData()
    })
  })

  

  const displaySelectedProperty = ()=>{
    const propertySection = document.getElementById('properties-section')
    const sectionString = `
      <div class="container mt-5 ">
          <a href="#" class="text-blue-600 hover:underline">Carcar</a> 
          <span class="mx-1">&gt;</span> 
          <a href="#" class="text-blue-600 hover:underline">Ang Dakong Balay (Don Florencio Noel Heritage House)</a>
      </div>
      <main class="container  flex flex-col py-5">
          <h1 class="text-4xl font-bold mb-4">Ang Dakong Balay (Don Florencio Noel Heritage House)</h1>
          <p class="text-lg text-gray-600 mb-5">Heritage House • Carcar</p>

          <div class="grid lg:grid-cols-12 gap-6">
              <div class="lg:col-span-7">
                  <div id="lighthouseCarousel" class="relative w-full mb-4" data-bs-ride="carousel">
                      <div class="overflow-hidden rounded-lg">
                          <div class="carousel-item active">
                              <img src="assets/images/carcar/1.jpg" class="w-full h-auto object-cover" alt="Lighthouse view 1">
                          </div>
                      </div>

                      <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full" type="button" data-bs-target="#lighthouseCarousel" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                      </button>
                      <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full" type="button" data-bs-target="#lighthouseCarousel" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                      </button>
                  </div>

                  <div class="flex space-x-2">
                      <img src="assets/images/carcar/1.jpg" class="h-16 w-16 object-cover rounded-lg cursor-pointer border-2 border-blue-500" alt="Thumbnail 1" data-bs-target="#lighthouseCarousel" data-bs-slide-to="0">
                  </div>
              </div>

              <div class="lg:col-span-5">
                  <button class="btn btn-outline-primary w-full block lg:hidden mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#lighthouseDetails" aria-controls="lighthouseDetails">
                      <i class="bi bi-info-circle mr-2"></i>View Details
                  </button>

                  <div class="hidden lg:block bg-white shadow-lg rounded-lg overflow-hidden">
                      <div class="details-content p-4">
                          <div id="lighthouseDetailsContent">
                              <!-- Content will be dynamically inserted here -->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>


      <div class="fixed hidden top-0 right-0 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out" tabindex="-1" id="lighthouseDetails" aria-labelledby="lighthouseDetailsLabel">
        <div class="border-b px-4 py-3 flex justify-between items-center">
            <h5 class="text-lg font-semibold" id="lighthouseDetailsLabel">Ang Dakong Balay (Don Florencio Noel Heritage House) Details</h5>
            <button type="button" class="text-gray-600 hover:text-gray-900" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="details-content p-4">
            <div>
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
      </div>

      `
      propertySection.innerHTML = sectionString


      const carousel = document.getElementById("lighthouseCarousel");
      const thumbnails = document.querySelectorAll(".carousel-thumbnail");
      const detailsContent = `
      <div class="mb-4">
          <h2 class="text-lg font-semibold mb-3">General Information</h2>
          <dl class="grid grid-cols-2 gap-y-3 text-sm">
              <dt class="font-medium text-gray-700">Official Name</dt>
              <dd class="text-gray-600">Bagacay Point Lighthouse[1]</dd>
              <dt class="font-medium text-gray-700">Classification</dt>
              <dd class="text-gray-600">National Historical Landmark[1]</dd>
              <dt class="font-medium text-gray-700">Location</dt>
              <dd class="text-gray-600">Lilo-an</dd>
          </dl>
      </div>
    
      <ul class="flex border-b mb-4 text-sm" id="detailsTabs" role="tablist">
          <li class="mr-4">
              <button class="px-4 py-2 text-blue-600 border-b-2 border-blue-600 focus:outline-none active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                  Description
              </button>
          </li>
          <li>
              <button class="px-4 py-2 text-gray-600 hover:text-blue-600 border-b-2 border-transparent focus:outline-none" id="sources-tab" data-bs-toggle="tab" data-bs-target="#sources" type="button" role="tab" aria-controls="sources" aria-selected="false">
                  Sources
              </button>
          </li>
      </ul>
    
      <div class="tab-content">
          <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <div class="description-text">
                  <div class="mb-4">
                      <span class="font-semibold">Tower</span>
                      <ul class="list-disc pl-6 text-gray-700">
                          <li>Constructed: 1857 (first), 1874 (second)</li>
                          <li>Foundation: Masonry</li>
                          <li>Construction: Concrete and stone tower (current), stone tower (second)</li>
                          <li>Height: 22 metres (72 ft) (current)</li>
                          <li>Shape: Octagonal tower with balcony and lantern (current), cylindrical tower with double balcony and lantern (second)</li>
                          <li>Markings: Unpainted tower, white lantern (current)</li>
                          <li>Fog signal: None</li>
                      </ul>
                  </div>
                  <p class="mb-4 text-gray-700">
                      The 172-foot lighthouse tower, located on an elevated 5,000-sq m government property overlooking
                      the Mactan Channel, has a focal plane of 146 feet. It was first lit on April 1, 1905, and stands
                      as an octagonal white masonry tower. Built by executive order from William Howard Taft on July 28, 1903,
                      it replaced the original 1857 Spanish government-established point light. This iconic lighthouse has
                      guided mariners, navigators, and fishermen for over a century and remains a popular subject for artists
                      and photographers due to its distinctive architectural design.[2]
                  </p>
                  <p class="mb-4 text-gray-700">
                      All navigational aids in the Philippines are managed by the Philippine Coast Guard.[2]
                  </p>
              </div>
          </div>
          <div class="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="sources-tab">
              <div class="mt-4 pt-3 border-t">
                  <p class="text-sm text-gray-500 mb-2">Sources:</p>
                  <ol class="list-decimal pl-6 text-sm text-gray-600">
                      <li>
                          <a href="https://ncca.gov.ph/philippine-registry-cultural-property-precup/" class="text-blue-600 hover:underline" target="_blank">
                              Philippine Registry of Cultural Property (PRECUP)
                          </a>
                      </li>
                      <li>
                          <a href="https://en.wikipedia.org/wiki/Bagacay_Point_Lighthouse" class="text-blue-600 hover:underline" target="_blank">
                              Wikipedia - Bagacay Point Lighthouse
                          </a>
                      </li>
                  </ol>
              </div>
          </div>
      </div>
    `;


      // Populate details content
  document.getElementById("lighthouseDetailsContent").innerHTML =
  detailsContent;
document.querySelector(".offcanvas .details-content").innerHTML =
  detailsContent;

// Carousel thumbnail functionality
carousel.addEventListener("slide.bs.carousel", function (e) {
  thumbnails.forEach((thumb) => thumb.classList.remove("active"));
  thumbnails[e.to].classList.add("active");
});

thumbnails.forEach((thumb) => {
  thumb.addEventListener("click", function () {
    thumbnails.forEach((t) => t.classList.remove("active"));
    this.classList.add("active");
  });
});

// Responsive behavior for details view
function handleResponsiveLayout() {
  const detailsCard = document.querySelector(".card");
  const viewDetailsBtn = document.querySelector(
    '[data-bs-toggle="offcanvas"]'
  );
  if (window.innerWidth >= 992) {
    detailsCard.classList.remove("d-none");
    detailsCard.classList.add("d-block");
    viewDetailsBtn.classList.add("d-none");
  } else {
    detailsCard.classList.add("d-none");
    detailsCard.classList.remove("d-block");
    viewDetailsBtn.classList.remove("d-none");
  }
}

window.addEventListener("resize", handleResponsiveLayout);
handleResponsiveLayout();


  }



 

//   const swiper = new Swiper('.swiper-container', {
//     loop: true,
//     navigation: {
//         nextEl: '.swiper-button-next',
//         prevEl: '.swiper-button-prev',
//     },
//     pagination: {
//         el: '.swiper-pagination',
//         clickable: true,
//     },
// });
  
});



const currentUrl = window.location.href;
const urlParams = new URLSearchParams(window.location.search);
let allProperties; //all properties from LCP and NCP
let areaNameParams = urlParams.get("area");
let areaIdParams = urlParams.get("areaid");
document.addEventListener("DOMContentLoaded", async function () {
  const showLoadingIndicatorDiv = async () => {
    // Get the parent element
    const listProperties = document.getElementById("list-properties-loading");
    // Create the div element for the loading indicator
    const indicatorDiv = document.createElement("div");
    indicatorDiv.id = "loading-indicator";
    indicatorDiv.className =
      "absolute inset-0 flex items-center justify-center"; // Make the div cover the entire parent with flex centering
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
    const div = document.querySelector("#loading-indicator");
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
      if (!response.ok) {
        throw new Error("Failed to get data from API");
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error("Failed to connect from API.");
    }
  };
  const ulAreas = document.getElementById("ul-areas");
  const areaData = await getAllAreas();
  // const area = areaData
  //   .map((areaItem) => {
  //     return `
  //       <li class="location-pill">
  //         <button 
  //           data-area="${areaItem.areaname}" 
  //           data-areaid="${areaItem.areaid}" 
  //           class="capitalize bg-white ${
  //             areaNameParams == areaItem.areaname
  //               ? "bg-[#ef4444] border-0 text-white hover:bg-[#dc2626]"
  //               : "text-gray-700"
  //           }  border border-gray-300 rounded-full px-3 py-1 text-sm font-medium hover:bg-gray-200"
  //           id="btnArea">
  //           ${areaItem.areaname}
  //         </button>
  //       </li>`;
  //   })
  //   .join("");
  // ulAreas.innerHTML = area;
  function renderAreaButtons(areaData) {
    const area = areaData
      .map((areaItem) => {
        return `
          <li class="location-pill">
            <button 
              data-area="${areaItem.areaname}" 
              data-areaid="${areaItem.areaid}" 
              class="capitalize bg-white ${
                areaNameParams == areaItem.areaname
                  ? "bg-[#ef4444] border-0 text-white hover:bg-[#dc2626]"
                  : "text-gray-700"
              } border border-gray-300 rounded-full px-2 py-0.5 text-xs font-medium hover:bg-gray-200"
              id="btnArea">
              ${areaItem.areaname}
            </button>
          </li>`;
      })
      .join("");
    ulAreas.innerHTML = area;
  
    // Re-attach event listeners after rendering
    attachAreaButtonListeners();
  }


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
                <img src="useruploads/lss/${lssFile ?? "no-photo.jpg"}" alt="${
              res.lssname
            }" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
                <div class="property-content p-4">
                  <a data-id="${
                    res.lssid
                  }" data-type="lcpid" id="selectPropertyBtn" class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${
              res.lssname ?? ""
            }</a>
                  <div class="property-type text-sm text-gray-500">${
                    res.lssclassificationstatus ?? ""
                  }</div>
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
      const findNcpProperty = ncpProperty.filter(
        (ncp) => ncp.areaid == areaIdParams
      );
      if (findNcpProperty.length === 0) {
        return []; // No NCP properties found
      }
      const resultFoundNcpProperty = await Promise.all(
        findNcpProperty.map(async (ncp) => {
          const ncpFile = await getNcpUploadedFile(ncp.ncpid);
          if (ncp.uploadstatus === 1) {
            return `
            <article class="property-card rounded-lg shadow bg-white flex flex-col">
              <img src="useruploads/ncp/${ncpFile ?? "no-photo.jpg"}" alt="${
              ncp.ncpname
            }" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
              <div class="property-content p-4">
                <a data-id=${
                  ncp.ncpid
                } data-type="ncpid" id="selectPropertyBtn" class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${
              ncp.ncpname ?? ""
            }</a>
                <div class="property-type text-sm text-gray-500">${
                  ncp.ncpclassificationstatus ?? ""
                }</div>
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
    showLoadingIndicatorDiv();
    try {
      const ncp = await displayNcpSelectedProperty(); // Get NCP data
      const lcp = await displayLcpSelectedProperty(); // Get LCP data
      const displayData = [...lcp, ...ncp];
      const paging = displayData.slice(1,10)


      const listOfProperties = document.getElementById("list-properties-div");
      const propertyTitle =document.querySelector(".properties-title")
      document.getElementById("properties-details").innerHTML = "";
      propertyTitle.classList.remove("hidden")
      if (listOfProperties) {
        if (paging.length === 0) {
          // No data found for both LCP and NCP
          listOfProperties.innerHTML = `<div class="no-data">No properties found | select area above.</div>`;
          return;
        }
        // Join and display the valid HTML strings
        listOfProperties.innerHTML = paging.join("")
      }
      const selectPropertyBtn = document.querySelectorAll("#selectPropertyBtn");
      if (selectPropertyBtn) {
        selectPropertyBtn.forEach((btnProperty) => {
          btnProperty.addEventListener("click", async () => {
            listOfProperties.innerHTML = "";
            propertyTitle.classList.add("hidden")

            const type = btnProperty.getAttribute("data-type");
            const id = btnProperty.getAttribute("data-id");
            console.log(type, id);
            const propertyData = await getProperty(type, id);
            // displaySelectedProperty();
            generateMainContent(propertyData);
          });
        });
      }
    } catch (error) {
      console.error("Something went wrong", error.message);
    } finally {
      hideLoadingIndicatorDiv();
    }
  };
  
  displayNcpAndLcpData();

  function attachAreaButtonListeners() {
    const btnArea = document.querySelectorAll("#btnArea");
    btnArea.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const btnAreaid = e.target.getAttribute("data-areaid");
        const btnAreaname = e.target.getAttribute("data-area");
  
        // Parse the current URL
        const url = new URL(window.location.href);
  
        areaNameParams = btnAreaname;
        areaIdParams = btnAreaid;
  
        // Update the query parameters
        url.searchParams.set("area", areaNameParams);
        url.searchParams.set("areaid", areaIdParams);
  
        window.history.replaceState({}, "", url);
  
        // Re-render the buttons to update the active state
        renderAreaButtons(areaData);
  
        // Call the function to display data
        displayNcpAndLcpData();
      });
    });
  }

  // Assuming areaData is available
renderAreaButtons(areaData);

  const getProperty = async (type, id) => {
    const response = await fetch(
      `backend/api/all-properties.php?${type}=${id}`,
      {
        method: "GET",
      }
    );
    const data = await response.json();
    return data;
  };

  function generateMainContent(data) {
    const propertySection = document.getElementById("properties-details");

    const hasNcpId = "ncpid" in data.property;
    const name = hasNcpId ? data.property.ncpname : data.property.lssname;
    const classification = hasNcpId
      ? data.property.ncpclassificationstatus
      : data.property.lssclassificationstatus;
    const location = hasNcpId
      ? data.property.ncptownorcity
      : data.property.lsstownorcity;
    const description = hasNcpId
      ? data.property.ncpdescription
      : data.property.lssdescription;

    const oldSourcesA = hasNcpId
      ? data.property.ncpsourceA
      : data.property.lsssource;
    const oldSourcesB = hasNcpId
      ? data.property.ncpsourceB
      : data.property.lsssourceB;

    const sources = data.url
      .map(
        (source) => `
    <li>
        <a href="${source.sourcelink}" class="text-blue-600 hover:underline" target="_blank" rel="noopener noreferrer">
            ${source.sourcelink}
        </a>
    </li>
`
      )
      .join("");

    // Extract image URLs for the carousel
    const imageData = data.uploaded;
    const hasImageData = imageData.length;
    console.log(imageData.length);
    const images = imageData.map((upload) => {
      const file = upload.user_upload_file[0];

      const path = hasNcpId ? file.ncppath : file.lsspath;
      const fileName = hasNcpId ? file.ncpfile : file.lssfile;

      return `${path}${fileName}`;
    });

    // Create the property content with dynamic images
    const propertyContent = `
    <div class="mb-8">
      <a id="btnBack" class="text-primary-600 underline cursor-pointer text-sm">${location}</a>
      >
      <a class="text-primary-600 underline cursor-text text-sm">${name}</a>
    </div>
  <h1 class="text-4xl font-bold mb-4">${name}</h1>
  <p class="text-xl mb-8">${classification} • ${location}</p>

  <div class="flex flex-col lg:flex-row gap-8">
    <div class="w-full lg:w-7/12">
     ${
       hasImageData
         ? ` <div id="lighthouseCarousel" class="relative mb-4 aspect-w-1 aspect-h-1 max-h-[650px] overflow-hidden">
        <img src="${
          images[0]
        }" alt="${name} view" class="w-full h-full object-contain rounded-lg">
        <p id="imageDescription" class="mt-2 text-center text-gray-600">${
          imageData[0].user_upload.description
        }</p>
        <button id="prevBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full">
            <span class="sr-only">Previous</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button id="nextBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full">
            <span class="sr-only">Next</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
      </div>
      <div class="flex space-x-2 overflow-x-auto scrollbar-hide pb-2">
            ${images
              .map(
                (img, index) => `
                <img src="${img}" class="w-20 h-20 object-cover rounded-lg cursor-pointer carousel-thumbnail ${
                  index === 0 ? "active" : ""
                }" alt="Thumbnail ${index + 1}" data-index="${index}">
            `
              )
              .join("")}
    
      </div>`
         : '<div class="w-full min-h-[600px] rounded-lg shadow-md bg-white my-auto text-center p-5"><p>There are currently no images available. You can help the community by sharing photos of this property here.<a href="./upload-photos" class="ms-2 p-2 py-1 text-xs rounded bg-primary-600 text-white">Upload here</a></p></div>'
     }
    </div>

    <div class="w-full lg:w-5/12">
        <button id="mobileDetailsBtn" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg shadow-md lg:hidden mb-4">
            View Details
        </button>
        <div id="detailsPanel" class="bg-white rounded-lg shadow-md overflow-y-scroll lg:block fixed inset-y-0 right-0 w-full max-w-sm lg:static lg:max-w-none transform translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:min-h-[600px] lg:h-[600px]">
            <div class="p-6">
                <button id="closeDetailsBtn" class="lg:hidden absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="text-xl font-semibold mb-4">General Information</h2>
                <dl class="grid grid-cols-3 gap-4">
                    <dt class="font-medium">Official Name</dt>
                    <dd class="col-span-2">${name}</dd>
                    <dt class="font-medium">Classification</dt>
                    <dd class="col-span-2">${classification}</dd>
                    <dt class="font-medium">Location</dt>
                    <dd class="col-span-2">${location}</dd>
                </dl>
            </div>
            <div class="border-t">
                <div class="flex">
                    <button id="descriptionTab" class="flex-1 py-3 px-4 text-center font-medium bg-gray-100 text-blue-600 border-b-2 border-blue-600">Description</button>
                    <button id="sourcesTab" class="flex-1 py-3 px-4 text-center font-medium text-gray-600 hover:bg-gray-50">Sources</button>
                </div>
                <div id="tabContent" class="p-6">
                    <div id="descriptionContent" class="space-y-4">
                        <div>
                           ${description.length > 0 ? description : `Help us improve this section by sharing information about this site. Reach out to us at community@pamana.org`}
                        </div>
                    </div>
                    <div id="sourcesContent" class="hidden">
                        <h3 class="font-semibold mb-2">Sources:</h3>
                        <ol class="list-decimal pl-5 space-y-2">
                            ${sources}
                            ${
                              oldSourcesA
                                ? `
                            <li><a href="${oldSourcesA}" class="text-blue-600 hover:underline" target="_blank" rel="noopener noreferrer">
                            ${oldSourcesA}
                              </a>
                            </li>`
                                : ""
                            }
                            ${
                              oldSourcesB
                                ? `
                            <li>
                            <a href="${oldSourcesB}" class="text-blue-600 hover:underline" target="_blank" rel="noopener noreferrer">
                              ${oldSourcesB}
                            </a>
                            </li>`
                                : ""
                            }
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>`;

    propertySection.innerHTML = propertyContent;

    // Initialize the carousel with the first image
    const carouselImage = document.querySelector("#lighthouseCarousel img");
    const thumbnails = document.querySelectorAll(".carousel-thumbnail");
    const imageDescription = document.getElementById("imageDescription");
    let currentIndex = 0;

    if (hasImageData) {
    function updateCarousel(index) {
      carouselImage.src = images[index];
      // imageDescription.textContent = imageData[index].user_upload.description + `<a href="${imageData[index].user_upload.source}>${imageData[index].user_upload.source_name}</a>"` + imageData[index].user_upload.date_taken;

      imageDescription.innerHTML = `
    <div class="flex gap-2 flex-wrap">
    <p class="">${imageData[index].user_upload.description}</p>
    <a href="${imageData[index].user_upload.source}" class="text-primary-600 underline ">${imageData[index].user_upload.source_name}</a>
    <p class="">${imageData[index].user_upload.date_taken}</p>
    </div>
    `;
      thumbnails.forEach((thumb, i) => {
        thumb.classList.toggle("ring-2", i === index);
        thumb.classList.toggle("ring-blue-500", i === index);
      });
    }

    updateCarousel(currentIndex);

    document.getElementById('btnBack').addEventListener('click',()=>{
      console.log("btn back is clicked")
      displayNcpAndLcpData()
    })

    document.getElementById("prevBtn").addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      updateCarousel(currentIndex);
    });

    document.getElementById("nextBtn").addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % images.length;
      updateCarousel(currentIndex);
    });

    thumbnails.forEach((thumb, index) => {
      thumb.addEventListener("click", () => {
        currentIndex = index;
        updateCarousel(currentIndex);
      });
    });
  }

    // Tab functionality
    const descriptionTab = document.getElementById("descriptionTab");
    const sourcesTab = document.getElementById("sourcesTab");
    const descriptionContent = document.getElementById("descriptionContent");
    const sourcesContent = document.getElementById("sourcesContent");

    function switchTab(tab, content) {
      descriptionTab.classList.remove(
        "bg-gray-100",
        "text-blue-600",
        "border-b-2",
        "border-blue-600"
      );
      sourcesTab.classList.remove(
        "bg-gray-100",
        "text-blue-600",
        "border-b-2",
        "border-blue-600"
      );
      descriptionContent.classList.add("hidden");
      sourcesContent.classList.add("hidden");

      tab.classList.add(
        "bg-gray-100",
        "text-blue-600",
        "border-b-2",
        "border-blue-600"
      );
      content.classList.remove("hidden");
    }

    descriptionTab.addEventListener("click", () =>
      switchTab(descriptionTab, descriptionContent)
    );
    sourcesTab.addEventListener("click", () =>
      switchTab(sourcesTab, sourcesContent)
    );

    // Mobile details panel functionality
    const mobileDetailsBtn = document.getElementById("mobileDetailsBtn");
    const closeDetailsBtn = document.getElementById("closeDetailsBtn");
    const detailsPanel = document.getElementById("detailsPanel");

    mobileDetailsBtn.addEventListener("click", () => {
      detailsPanel.classList.remove("translate-x-full");
      detailsPanel.classList.add("translate-x-0");
    });

    closeDetailsBtn.addEventListener("click", () => {
      detailsPanel.classList.remove("translate-x-0");
      detailsPanel.classList.add("translate-x-full");
    });

    // Handle resize events to ensure proper display on orientation change or window resize
  }
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 1024) {
      detailsPanel.classList.remove("translate-x-full", "translate-x-0");
    } else {
      detailsPanel.classList.add("translate-x-full");
    }
  });
});

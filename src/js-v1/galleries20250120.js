const currentUrl = window.location.href;
const urlParams = new URLSearchParams(window.location.search);
let allProperties; //all properties from LCP and NCP
let areaNameParams = urlParams.get("area");
let areaIdParams = urlParams.get("areaid");
let tempNCP = [];
let tempLCP = [];
let currentPage = 1; // Tracks the current page
const MODEL_DATA = [
  {
    type: "ncp",
    id: 1008
  },
  {
    type: "ncp",
    id: 1014
  },{
    type: "ncp",
    id: 1139
  },
  {
    type: "lcp",
    id: 2058
  },
  {
    type: "lcp",
    id: 2071
  },
  {
    type: "lcp",
    id: 2018
  }
]
const pageSize = 9; // Number of items per page
let allPropertiesCache = [];
const listOfProperties = document.getElementById("list-properties-div");
const propertyTitle = document.querySelector(".properties-title");

const inputSearch = document.getElementById("inputSearch");
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

  const displaySelectedProperty = async () => {
    if (areaNameParams && areaIdParams) {
      if (tempLCP.length === 0 || tempNCP.length === 0) {
        tempNCP = await getNcpProperty();
        tempLCP = await getLcpProperty();
      }

      const findNcpProperty = tempNCP.filter(
        (ncp) => ncp.areaid == areaIdParams
      );
      const findLcpProperty = tempLCP.filter(
        (lcp) => lcp.areaid == areaIdParams
      );

      if (findNcpProperty.length === 0 && findLcpProperty.length === 0) {
        return []; // No properties found
      }

      // Sort NCP and LCP properties individually
      findNcpProperty.sort((a, b) => a.ncpname.localeCompare(b.ncpname));
      findLcpProperty.sort((a, b) => a.lssname.localeCompare(b.lssname));

      // Combine and sort both arrays
      const combinedProperties = [...findNcpProperty, ...findLcpProperty].sort(
        (a, b) => {
          const nameA = a.ncpname ? a.ncpname : a.lssname;
          const nameB = b.ncpname ? b.ncpname : b.lssname;
          return nameA.localeCompare(nameB);
        }
      );

      // Log the sorted combined properties
      const resultFoundProperties = await Promise.all(
        combinedProperties.map(async (item) => {
          let htmlString = "";
          let file, name, classificationStatus;

          if (item.ncpid) {
            // It's an NCP property
            file = await getNcpUploadedFile(item.ncpid);
            name = item.ncpname;
            classificationStatus = item.ncpclassificationstatus;

            if (item.uploadstatus === 1) {
              htmlString = `
                <article class="property-card cursor-pointer property-link rounded-lg shadow bg-white flex flex-col">
                  <a data-id=${
                    item.ncpid
                  } data-type="ncpid" id="selectPropertyBtn">
                    <img src="useruploads/ncp/${
                      file ?? "no-photo.jpg"
                    }" alt="${name}" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
                    <div class="property-content p-4">
                      <p class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${
                        name ?? ""
                      }</p>
                      <div class="property-type text-sm text-gray-500">${
                        classificationStatus ?? ""
                      }</div>
                    </div>
                  </a>
                </article>
              `;
            }
          } else if (item.lssid) {
            // It's an LCP property
            file = await getLcpUploadedFile(item.lssid);
            name = item.lssname;
            classificationStatus = item.lssclassificationstatus;

            if (item.uploadstatus === 1) {
              htmlString = `
                <article class="property-card cursor-pointer property-link rounded-lg shadow bg-white flex flex-col">
                  <a data-id=${
                    item.lssid
                  } data-type="lcpid" id="selectPropertyBtn">
                    <img src="useruploads/lss/${
                      file ?? "no-photo.jpg"
                    }" alt="${name}" class="property-image object-cover rounded-tl-lg rounded-tr-md h-48 w-full">
                    <div class="property-content p-4">
                      <p class="property-link text-lg font-semibold text-primary-700 hover:text-primary-500">${
                        name ?? ""
                      }</p>
                      <div class="property-type text-sm text-gray-500">${
                        classificationStatus ?? ""
                      }</div>
                    </div>
                  </a>
                </article>
              `;
            }
          }

          return htmlString || null;
        })
      );

      // Filter out null/undefined values and return only valid HTML strings
      return resultFoundProperties.filter(Boolean);
    }
    return []; // If no areaName or areaId, return empty array
  };

  const displayNcpAndLcpData = async () => {
    showLoadingIndicatorDiv();
    try {
      const properties = await displaySelectedProperty(); // Get NCP data
      allPropertiesCache = properties; // Cache all property data
      propertyTitle.classList.remove("hidden");
      document.getElementById("properties-details").innerHTML = "";
      if (!listOfProperties) return;

      if (allPropertiesCache.length > 9) {
        renderPagination(allPropertiesCache.length);
      }

      renderPage(allPropertiesCache);

      attachPropertyListeners();
    } catch (error) {
      console.error("Something went wrong", error.message);
    } finally {
      hideLoadingIndicatorDiv();
    }
  };

  const renderPagination = (totalProperties) => {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";
    const totalPages = Math.ceil(totalProperties / pageSize);

    // If only one page, no need for pagination
    if (totalPages === 1) {
      return;
    }

    const maxPagesToShow = 5; // Maximum number of page buttons to display
    const halfRange = Math.floor(maxPagesToShow / 2);

    let startPage = Math.max(1, currentPage - halfRange);
    let endPage = Math.min(totalPages, currentPage + halfRange);

    // Adjust range if near the beginning or end
    if (currentPage <= halfRange) {
      endPage = Math.min(totalPages, maxPagesToShow);
    }
    if (currentPage + halfRange >= totalPages) {
      startPage = Math.max(1, totalPages - maxPagesToShow + 1);
    }

    // Create "Previous" button
    const prevButton = document.createElement("button");
    prevButton.textContent = "Previous";
    prevButton.className =
      "prev-btn bg-gray-200 px-4 py-2 rounded hover:bg-gray-300";
    prevButton.disabled = currentPage === 1; // Disable if on the first page
    prevButton.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        displayNcpAndLcpData();
      }
    });
    pagination.appendChild(prevButton);

    // Add "..." before the first visible page if necessary
    if (startPage > 1) {
      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.className = "px-2";
      pagination.appendChild(dots);
    }

    // Create numbered buttons
    for (let i = startPage; i <= endPage; i++) {
      const pageButton = document.createElement("button");
      pageButton.textContent = i;
      pageButton.className = `page-btn px-4 py-2 rounded ${
        i === currentPage
          ? "bg-[#164c70] text-white"
          : "bg-gray-200 hover:bg-gray-300"
      }`;
      pageButton.addEventListener("click", () => {
        currentPage = i;
        displayNcpAndLcpData();
      });
      pagination.appendChild(pageButton);
    }

    // Add "..." after the last visible page if necessary
    if (endPage < totalPages) {
      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.className = "px-2";
      pagination.appendChild(dots);
    }

    // Create "Next" button
    const nextButton = document.createElement("button");
    nextButton.textContent = "Next";
    nextButton.className =
      "next-btn bg-gray-200 px-4 py-2 rounded hover:bg-gray-300";
    nextButton.disabled = currentPage === totalPages; // Disable if on the last page
    nextButton.addEventListener("click", () => {
      if (currentPage < totalPages) {
        currentPage++;
        displayNcpAndLcpData();
      }
    });
    pagination.appendChild(nextButton);
  };

  const renderPage = (totalProperties) => {
    const pagination = document.getElementById("pagination");
    const listOfProperties = document.getElementById("list-properties-div");
    listOfProperties.innerHTML = "";

    const start = (currentPage - 1) * pageSize;
    const end = currentPage * pageSize;
    const pagingData = totalProperties.slice(start, end);

    if (pagingData.length === 0) {
      pagination.innerHTML = "";
      // listOfProperties.innerHTML = ``;
      listOfProperties.innerHTML = areaIdParams && areaNameParams ? `<div class="no-data col-span-full">No properties enlisted. <br> <i class="text-gray-500">Help expand this page by nominating a heritage site. Reach out to us at community@pamana.org</i></div>` : `<div class="no-data">Select a city or municipality.</div>`
      return;
    }

    listOfProperties.innerHTML = pagingData.join("");
    attachPropertyListeners();
  };

  // Attach event listeners to property buttons
  const attachPropertyListeners = () => {
    const selectPropertyBtn = document.querySelectorAll("#selectPropertyBtn");
    if (selectPropertyBtn) {
      selectPropertyBtn.forEach((btnProperty) => {
        btnProperty.addEventListener("click", async () => {
          listOfProperties.innerHTML = "";
          propertyTitle.classList.add("hidden");
          document.getElementById("pagination").innerHTML = "";

          // console.log(document.title = "sample")

          const type = btnProperty.getAttribute("data-type");
          const id = btnProperty.getAttribute("data-id");
          const propertyData = await getProperty(type, id);
          generateMainContent(propertyData);
        });
      });
    }
  };
 

  if (inputSearch) {
    inputSearch.addEventListener("input", async () => {
      const searchValue = inputSearch.value.toLowerCase(); // Normalize search input
      const listOfProperties = document.getElementById("list-properties-div");
      listOfProperties.innerHTML = "";

      // Check if cached data is empty, then fetch and cache all properties
      if (allPropertiesCache.length === 0) {
        // const properties = await displaySelectedProperty(); // Fetch NCP data
        allPropertiesCache = await displaySelectedProperty(); // Cache all property data
      }

      // Filter properties based on search input
      const filteredProperties = allPropertiesCache.filter((propertyHTML) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(propertyHTML, "text/html"); // Parse HTML string into a document
        const propertyName =
          doc.querySelector(".property-link")?.textContent.toLowerCase() || "";
        return propertyName.includes(searchValue); // Check if property name includes search term
      });

      // Re-render the filtered properties
      if (listOfProperties) {
        if (filteredProperties.length === 0) {
          listOfProperties.innerHTML = `<div class="no-data">No properties match your search.</div>`;
        } else {
          listOfProperties.innerHTML = filteredProperties.join("");
        }
      }

      // Attach event listeners to filtered properties
      attachPropertyListeners();
    });
  }


  function attachAreaButtonListeners() {
    const btnArea = document.querySelectorAll("#btnArea");
    
    btnArea.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const btnAreaid = e.target.getAttribute("data-areaid");
        const btnAreaname = e.target.getAttribute("data-area");

        // Parse the current URL
        const url = new URL(window.location.href);
        url.search = ""

        areaNameParams = btnAreaname;
        areaIdParams = btnAreaid;

        // Update the query parameters
        url.searchParams.set("area", areaNameParams);
        url.searchParams.set("areaid", areaIdParams);

        window.history.replaceState({}, "", url);

        // Re-render the buttons to update the active state
        renderAreaButtons(areaData);

        pamanaTitle(false)

        // Call the function to display data and clear existing content
        const listOfProperties = document.getElementById("list-properties-div");
        if (listOfProperties) {
          listOfProperties.innerHTML = ""; // Clear previous content
          document.getElementById("pagination").innerHTML = "";
        }
        currentPage = 1;
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

  const displayPropertyByUrlParams = async()=>{
    const urlPropertyID = urlParams.get("id")
    const type = urlParams.get("type")

    if(urlPropertyID && type){
      const urlPropertyData = await getProperty(type, urlPropertyID);
      generateMainContent(urlPropertyData);
    }
  }
  if(urlParams.get('id')){
    displayPropertyByUrlParams()
  }else{
    displayNcpAndLcpData();
  }

  function generateMainContent(data) {
    const propertySection = document.getElementById("properties-details");

    const hasNcpId = "ncpid" in data.property;
    const id = hasNcpId ? data.property.ncpid : data.property.lssid;
    const name = hasNcpId ? data.property.ncpname : data.property.lssname;
    pamanaTitle(true, name)
    const classification = hasNcpId
      ? data.property.ncpclassificationstatus
      : data.property.lssclassificationstatus;

    const additionalLssDataString = `
    ${
      data.property.lssyeardeclared
        ? `<dt class="font-medium">Year Declared</dt><dd class="col-span-2">${data.property.lssyeardeclared}</dd>`
        : ""
    }
    ${
      data.property.lssotherdeclarations
        ? `<dt class="font-medium">Other Declarations</dt><dd class="col-span-2">${data.property.lssotherdeclarations}</dd>`
        : ""
    }
    ${
      data.property.lsslegislation
        ? `<dt class="font-medium">Legislation</dt>
    <dd class="col-span-2">${data.property.lsslegislation}</dd>`
        : ""
    }
    
    `;
    const additionalNcpDataString = `
    
    ${
      data.property.ncpotherdeclarations
        ? `<dt class="font-medium">Other Declarations</dt><dd class="col-span-2">${data.property.ncpotherdeclarations}</dd>`
        : ""
    }
    
    `;
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
    const images = imageData.map((upload) => {
      const file = upload.user_upload_file[0];

      const path = hasNcpId ? file.ncppath : file.lsspath;
      const fileName = hasNcpId ? file.ncpfile : file.lssfile;

      return `${path}${fileName}`;
    });

    const model = MODEL_DATA.find(mdl => mdl.id == id);

    // Create the property content with dynamic images
    const propertyContent = `
    <div class="mb-8">
      <a id="btnBack" class="text-primary-600 underline cursor-pointer text-sm">${location}</a>
      >
      <a class="text-primary-600 underline cursor-text text-sm">${name}</a>
    </div>
  <h1 class="text-4xl font-bold mb-4">${name}</h1>

  <div class="flex flex-col lg:flex-row gap-8">
    <div class="w-full lg:w-7/12">
     ${
       hasImageData
         ? ` <div id="lighthouseCarousel" class="relative mb-4 aspect-w-1 aspect-h-1 max-h-[650px] h-[600px] overflow-hidden">
        <img src="${
          images[0]
        }" alt="${name} view" class="w-full h-full bg-black object-contain rounded-lg">
        <p id="imageDescription" class="mt-2 text-center z-[99] absolute bottom-0 text-xs w-full bg-gradient-to-t from-black to-transparent">${
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
         : `<div class="w-full min-h-[600px] rounded-lg shadow-md text-white ${
             hasImageData ? "bg-white" : "bg-black"
           } my-auto content-center text-center p-5"><p>There are currently no images available. You can help the community by sharing photos of this property here.<a href="./upload-photos?${
             hasNcpId ? "ncpid" : "lcpid"
           }=${id}&areaname=${name}" class="ms-2 p-2 py-1 text-xs rounded bg-primary-600 text-white">Upload here</a></p></div>`
     }
    </div>

    <div class="w-full lg:w-5/12">
        <button id="mobileDetailsBtn" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg shadow-md lg:hidden mb-4">
            View Details
        </button>

        <div id="detailsPanelBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-90 hidden md:hidden lg:hidden"></div>

        <div id="detailsPanel" class="bg-white rounded-lg shadow-md overflow-y-scroll lg:block fixed inset-y-0 right-0 w-full max-w-sm lg:static lg:max-w-none transform translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:min-h-[600px] lg:h-[600px] z-[100]">
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
                    ${additionalNcpDataString}
                    ${additionalLssDataString}
                    <dt class="font-medium">Location</dt>
                    <dd class="col-span-2">${location}</dd>
                </dl>
            </div>
            <div class="border-t">
                <div class="flex">
                    <button id="descriptionTab" class="flex-1 py-3 px-4 text-center font-medium bg-gray-100 text-blue-600 border-b-2 border-blue-600">Description</button>
                    <button id="modelTab" class="flex-1 py-3 px-4 text-center font-medium text-gray-600 hover:bg-gray-50 ${!model ? 'hidden' : ''}">Model</button>
                    <button id="sourcesTab" class="flex-1 py-3 px-4 text-center font-medium text-gray-600 hover:bg-gray-50">Sources</button>
                </div>
                <div id="tabContent" class="">
                    <div id="descriptionContent" class="space-y-4 p-6">
                        <div>
                           ${
                             description.length > 0
                               ? description
                               : `<i>Help us improve this section by sharing information about this site. Reach out to us at community@pamana.org</i>`
                           }
                        </div>
                    </div>
                     <div id="modelContent" class="space-y-4 ${!model ? 'hidden' : ''} w-full]">
                        <div class="w-full flex justify-center items-center">
                          ${model ?
                            ` <a id="modelLink" href="./model/${model.id}" class="w-full p-3 hidden text-primary-500 text-center  rounded font-semibold">
                           <img src="assets/model-images/${model && model.id}.jpg" class="rounded h-64 mx-auto shadow mb-2"><img>
                           VIEW 3D MODEL
                           
                           </a>` :
                           ''
                          }
                           
                        </div>
                    </div>
                    <div id="sourcesContent" class="hidden p-6">
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

    document.getElementById("btnBack").addEventListener("click", () => {
      const url = new URL(window.location.href);
      url.search = ""
      url.searchParams.set("area", areaNameParams);
      url.searchParams.set("areaid", areaIdParams);

      window.history.replaceState({}, "", url);

      // Re-render the buttons to update the active state
      renderAreaButtons(areaData);

      pamanaTitle(false)

      displayNcpAndLcpData();
    });

    if (hasImageData) {
      function updateCarousel(index) {
        carouselImage.src = images[index];
        imageDescription.innerHTML = `
    <div class="flex gap-2 flex-wrap justify-center text-xs mb-2">
    <p class="text-white">${imageData[index].user_upload.description}</p>
    <a href="${imageData[index].user_upload.source}" class="text-blue-500 underline ">${imageData[index].user_upload.source_name}</a>
    <p class="text-white">${imageData[index].user_upload.date_taken}</p>
    </div>
    `;
        thumbnails.forEach((thumb, i) => {
          thumb.classList.toggle("ring-2", i === index);
          thumb.classList.toggle("ring-blue-500", i === index);
        });
      }

      updateCarousel(currentIndex);

  

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
    const modelTab = document.getElementById("modelTab");
    const descriptionContent = document.getElementById("descriptionContent");
    const sourcesContent = document.getElementById("sourcesContent");
    const modelContent = document.getElementById("modelContent");


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
      modelTab.classList.remove(
        "bg-gray-100",
        "text-blue-600",
        "border-b-2",
        "border-blue-600"
      );
      descriptionContent.classList.add("hidden");
      sourcesContent.classList.add("hidden");
      modelContent.classList.add("hidden");

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
    modelTab.addEventListener("click", () =>{
      switchTab(modelTab, modelContent)
      document.getElementById("modelLink").classList.remove("hidden")
    }
    );

    const toggleDetailsPanelBackdrop = (show)=>{
      const detailsPanelBackdrop = document.getElementById("detailsPanelBackdrop")
      if(show){
        detailsPanelBackdrop.classList.remove("hidden")
      }else{
        detailsPanelBackdrop.classList.add("hidden")
      }
    }
    toggleDetailsPanelBackdrop(false)
    // Mobile details panel functionality
    const mobileDetailsBtn = document.getElementById("mobileDetailsBtn");
    const closeDetailsBtn = document.getElementById("closeDetailsBtn");
    const detailsPanel = document.getElementById("detailsPanel");

    mobileDetailsBtn.addEventListener("click", () => {
      detailsPanel.classList.remove("translate-x-full");
      detailsPanel.classList.add("translate-x-0");
      toggleDetailsPanelBackdrop(true)
    });

    closeDetailsBtn.addEventListener("click", () => {
      detailsPanel.classList.remove("translate-x-0");
      detailsPanel.classList.add("translate-x-full");
      toggleDetailsPanelBackdrop(false)
    });

    // Handle resize events to ensure proper display on orientation change or window resize
    window.addEventListener("resize", () => {
      if (window.innerWidth >= 1024) {
        detailsPanel.classList.remove("translate-x-full", "translate-x-0");
        toggleDetailsPanelBackdrop(false)
      } else {
        detailsPanel.classList.add("translate-x-full");
        
      }
    });
  }
});
// Get the 'to top' button element by ID
var toTopButton = document.getElementById("to-top-button");

// Check if the button exists
if (toTopButton) {
  // On scroll event, toggle button visibility based on scroll position
  window.onscroll = function () {
    if (
      document.body.scrollTop > 500 ||
      document.documentElement.scrollTop > 500
    ) {
      toTopButton.classList.remove("hidden");
    } else {
      toTopButton.classList.add("hidden");
    }
  };

  // Function to scroll to the top of the page smoothly
  window.goToTop = function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  };
  // Center the 'To Top' button
  toTopButton.style.left = "50%";
  toTopButton.style.transform = "translateX(-50%)";
}
const pamanaTitle = (isDisplay, title = null) =>{
  if(isDisplay){
    document.title = "PAMANA | " + title
  }else{
    document.title = "PAMANA | Preserving our cultural legacy for future generations."
  }
}

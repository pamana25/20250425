
const toggleSearch = document.getElementById("toggle-search");
const mdSearchToggle = document.getElementById("md-search-toggle");

mdSearchToggle.addEventListener('click', ()=>{
  toggleSearch.click();
})



toggleSearch.addEventListener('click', () => {
  document.body.append(generateDialog());
  const searchData = document.getElementById("searchData");
  // console.log(generateDialog());
  const dialog = document.getElementById("searchDialog")
  dialog.showModal();
  const search = document.querySelector('input[name="search');
  search.addEventListener("input", async (e) => {
    e.preventDefault();
    const searchValue = search.value.trim();
    console.log(searchValue);
    searchData.innerHTML = "";

    getAreasData();
  });

  const searchFilter = document.getElementById("searchFilter");

  searchFilter.addEventListener('change', (e)=>{
    searchData.innerHTML = "";
    getAreasData();

  })

  window.addEventListener('click', (event) => {
    if (event.target === dialog) {
      searchData.innerHTML = "";
        dialog.close();
    }
  });

  
  })




//search function to get data from search by areas or structures
const getAreasData = async () => {
  try {
    
    const form = document.getElementById("searchForm");
    form.addEventListener('submit', (e)=>{
      e.preventDefault();
    })
    const formData = new FormData(form);
    const option = {
      method: "POST",
      body: formData,
    };

    const response = await fetch("/pamana/_db/functions.php", option);

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();
    const areaObjects = Object.values(data).filter(
      (obj) => typeof obj === "object"
    );

    const searchResult = ()=>{
      
      const searchData = document.getElementById("searchData");
      const searchResultIndicator = document.createElement('div');
      searchResultIndicator.className = "fw-bold cbh-color-blue mb-2"
      searchResultIndicator.innerHTML = 'Search result';
      searchData.appendChild(searchResultIndicator);
      console.log(searchData)

    }
    searchResult();



    if (!areaObjects || areaObjects.length === 0) {
      const noDataString = `<span class="fs-6 text-center my-auto" style="color:#164c70">Search not found</span>`;
      searchData.innerHTML = noDataString;
      console.log("Search not found");
      console.log(data)
     
      return;
      
    }

    

    if (data.type === "areas") {

      

      // Iterate over each areaObject
      areaObjects.forEach((areaObject) => {
        console.log(areaObject);
        const newDiv = document.createElement("div");
        newDiv.innerHTML = `
        <p role="button" class="text-capitalize px-3 py-2 m-0 p-hover fs-6 fw-bold">${areaObject.areaname}
                            </p>`;
        searchData.appendChild(newDiv);

        newDiv.querySelector("p").addEventListener("click", () => {
          console.log("Clicked on: ", areaObject.areaname);
          const searchData = document.getElementById("searchData");
          const clickSearch = document.querySelector('input[name="search"]')
          clickSearch.value = areaObject.areaname
          searchData.innerHTML = "";
          searchData.innerHTML = `<span class="text-capitalize cbh-color-blue fs-6 fw-bold ">${areaObject.areaname}</span>`;
          getMoreData(areaObject);
        });
      });
    }

    else if (data.type === "structure") {

      areaObjects.forEach((structureObject) => {
        console.log(structureObject);
        const newDiv = document.createElement("div");
        newDiv.innerHTML = `
        <a class=" m-0 text-decoration-none"
           href="${structureObject.sourceID >= 1999 ? "lssgallery" : "ncpgallery"
          }?${structureObject.sourceID >= 1999 ? "lss" : "ncp"}=${structureObject.sourceID
          }"><p class="p-2 m-0">
            ${structureObject.sourceName}
            </p>
          </a>
       
      `;
        searchData.appendChild(newDiv);
      });
    }
  } catch (error) {
    console.error("Error:", error);
  }
};
//get more data when the user clicks on areas
const getMoreData = async (element) => {
  const newId = element.areaid;
  try {
    const options = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: newId,
      }),
    };

    const response = await fetch(
      "/pamana/_db/functions.php?action=getMoreData",
      options
    );
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    if (response.headers.get("Content-Type") !== "application/json") {
      throw new Error("Expected response to be JSON");
    }

    const moreData = await response.json();
    console.log("moreData", moreData);
    const newDataWrapper = document.createElement("div");
    newDataWrapper.innerHTML += `
    <div class="cbh-color-blue mt-2 "><h5 class="fw-bold text-xl">Local Cultural Properties</h5><ul  id="lcpData"></ul></div>
      <div  class="cbh-color-blue "><h5 class="fw-bold">National Cultural Properties</h5><ul id="ncpData"></ul></div>
       `;

    searchData.appendChild(newDataWrapper);
    const lcpContent = newDataWrapper.querySelector("#lcpData");
    const ncpContent = newDataWrapper.querySelector("#ncpData");
    let ncpDataFound = false;
    let lcpDataFound = false;

    moreData.forEach((items) => {
      const sourceIdNumber = parseInt(items.sourceID, 10);


      if (sourceIdNumber >= 1000 && sourceIdNumber <= 1999) {
        ncpContent.innerHTML += `<li class="p-0 m-0"><a class="text-decoration-none" href="ncpgallery?ncp=${sourceIdNumber}">${items.sourceName}</a></li>`;
        ncpDataFound = true;
      } else if (sourceIdNumber >= 2000 && sourceIdNumber <= 2999) {
        lcpContent.innerHTML += `<li class="p-0 m-0"><a class="text-decoration-none" href="lssgallery?lss=${sourceIdNumber}">${items.sourceName}</li>`;
        lcpDataFound = true;
      } else {
        console.log("Unknown source:", items.sourceId, items.sourceName);
      }
    });

    if (!ncpDataFound) {
      ncpContent.innerHTML = '<li class="p-0 m-0">No data found</li>';
    }

    
    if (!lcpDataFound) {
      lcpContent.innerHTML = '<li class="p-0 m-0">No data found</li>';
    }
  } catch (error) {
    console.error("Error:", error);
    if (error instanceof SyntaxError) {
      console.error("Invalid JSON response received:", error.message);
    } else {
      
    }
  }
};

function generateDialog() {

  const dialog = document.createElement("dialog");
  dialog.setAttribute("id", "searchDialog")
  dialog.classList.add("position-absolute", "top-50", "start-50", "translate-middle", "border-0", "rounded-2", "overflow-hidden")
  dialog.style.width = "900px";
  dialog.style.height = "500px";
  dialog.innerHTML = `
          <form id="searchForm" class="d-flex justify-content-center shadow-sm align-items-center w-100 px-4 py-4 border-bottom-3 gap-2" style="border-bottom: 3px solid #164c70;"  autocomplete="off">
             <div class="w-100 d-flex justify-content-center form-control align-items-center gap-3">
              <span><i class="bi bi-search cbh-color-blue fs-5"></i></span>
              <div class="input-group">
                <input type="text" class="form-control border-0 w-75 shadow-none" name="search" placeholder="Quick search...">
                <select role="button" class="form-select shadow-none border-0 cbh-color-blue" name="searchby" id="searchFilter">
                 <option value="areas">Location</option>
                 <option value="structure">Structure</option>
               </select>
              </div>
              
               <input type="hidden" name="formAction" value="search" id="formAction">
             </div>
           
               
             
             <span id="hideModal" role="button" class="cbh-color-blue"><i class="bi bi-x fs-2"></i></span> 
           </form>
           

           <div id="searchData" class="px-4 py-2 overflow-auto  h-75"></div>`;

  const hideModal = dialog.querySelector('#hideModal');
  hideModal.addEventListener('click', () => {
    document.body.removeChild(dialog);
  })

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      document.body.removeChild(dialog);
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Backspace") {
        document.getElementById("searchData").innerHTML = "";
    }
  });


  return dialog;

}



const displayNcpAndLcpData = async () => {
  const listOfProperties = document.getElementById("list-properties-div");
  const propertyTitle = document.querySelector(".properties-title");
  const propertiesDetails = document.getElementById("properties-details");

  let page = 1; // Start with page 1
  const pageSize = 9; // Combined number of items to load per request
  let isLoading = false; // To prevent multiple simultaneous requests
  let hasMoreData = true; // Flag to indicate if there is more data to load

  const showLoadingIndicatorDiv = () => {
    const loadingDiv = document.createElement("div");
    loadingDiv.id = "loading";
    loadingDiv.className = "loading-indicator";
    loadingDiv.textContent = "Loading...";
    listOfProperties.appendChild(loadingDiv);
  };

  const hideLoadingIndicatorDiv = () => {
    const loadingDiv = document.getElementById("loading");
    if (loadingDiv) loadingDiv.remove();
  };

  const fetchData = async () => {
    if (isLoading || !hasMoreData) return; // Avoid multiple fetches or fetching when no more data
    isLoading = true;
    showLoadingIndicatorDiv();

    try {
      // Divide page size evenly between NCP and LCP
      const ncpPageSize = Math.ceil(pageSize / 2);
      const lcpPageSize = Math.floor(pageSize / 2);

      // Fetch paginated NCP and LCP properties
      const ncpData = await displayNcpSelectedProperty(page, ncpPageSize);
      const lcpData = await displayLcpSelectedProperty(page, lcpPageSize);

      const displayData = [...lcpData, ...ncpData];

      if (displayData.length === 0) {
        hasMoreData = false; // No more data to load
        if (page === 1) {
          listOfProperties.innerHTML = `<div class="no-data">No properties found | select area above.</div>`;
        }
        return;
      }

      propertyTitle.classList.remove("hidden");
      propertiesDetails.innerHTML = ""; // Clear the details section

      // Append new data to the list of properties
      listOfProperties.innerHTML += displayData.join("");

      // Re-attach click event listeners for dynamically added elements
      attachSelectPropertyButtonListeners();

      page++; // Increment page number for the next fetch

      const selectPropertyBtn = document.querySelectorAll("#selectPropertyBtn");
      if (selectPropertyBtn) {
        selectPropertyBtn.forEach((btnProperty) => {
          btnProperty.addEventListener("click", async () => {
            listOfProperties.innerHTML = "";
            propertyTitle.classList.add("hidden");

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
      isLoading = false;
      hideLoadingIndicatorDiv();
    }
  };

  const attachSelectPropertyButtonListeners = () => {
    const selectPropertyBtn = document.querySelectorAll("#selectPropertyBtn");
    if (selectPropertyBtn) {
      selectPropertyBtn.forEach((btnProperty) => {
        btnProperty.addEventListener("click", async () => {
          listOfProperties.innerHTML = "";
          propertyTitle.classList.add("hidden");

          const type = btnProperty.getAttribute("data-type");
          const id = btnProperty.getAttribute("data-id");
          console.log(type, id);
          const propertyData = await getProperty(type, id);
          generateMainContent(propertyData);
        });
      });
    }
  };

  const handleScroll = () => {
    // Detect if the user is near the bottom of the page
    if (
      window.innerHeight + window.scrollY >=
      document.documentElement.scrollHeight - 100
    ) {
      fetchData();
    }
  };

  // Initial fetch
  await fetchData();

  // Attach scroll event listener
  window.addEventListener("scroll", handleScroll);

  const selectPropertyBtn = document.querySelectorAll("#selectPropertyBtn");
  if (selectPropertyBtn) {
    selectPropertyBtn.forEach((btnProperty) => {
      btnProperty.addEventListener("click", async () => {
        listOfProperties.innerHTML = "";
        propertyTitle.classList.add("hidden");

        const type = btnProperty.getAttribute("data-type");
        const id = btnProperty.getAttribute("data-id");
        console.log(type, id);
        const propertyData = await getProperty(type, id);
        // displaySelectedProperty();
        generateMainContent(propertyData);
      });
    });
  }
};

// Updated `displayNcpSelectedProperty` and `displayLcpSelectedProperty` for pagination
const displayNcpSelectedProperty = async (page, pageSize) => {
  if (areaNameParams && areaIdParams) {
    const ncpProperty = await getNcpProperty();
    const findNcpProperty = ncpProperty.filter(
      (ncp) => ncp.areaid == areaIdParams
    );

    const paginatedData = findNcpProperty.slice(
      (page - 1) * pageSize,
      page * pageSize
    );

    if (paginatedData.length === 0) {
      return []; // No NCP properties found
    }

    const resultFoundNcpProperty = await Promise.all(
      paginatedData.map(async (ncp) => {
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

    return resultFoundNcpProperty.filter(Boolean);
  }
  return [];
};

const displayLcpSelectedProperty = async (page, pageSize) => {
  if (areaNameParams && areaIdParams) {
    const lcpProperty = await getLcpProperty();
    const findLcpProperty = lcpProperty.filter(
      (lcp) => lcp.areaid == areaIdParams
    );

    const paginatedData = findLcpProperty.slice(
      (page - 1) * pageSize,
      page * pageSize
    );

    if (paginatedData.length === 0) {
      return []; // No LCP properties found
    }

    const resultFoundLcpProperty = await Promise.all(
      paginatedData.map(async (res) => {
        const lssFile = await getLcpUploadedFile(res.lssid);
        if (res.uploadstatus === 1) {
          return `
              <article class="property-card rounded-lg shadow bg-white flex flex-col">
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

    return resultFoundLcpProperty.filter(Boolean);
  }
  return [];
};

let ncpAndlcpData = [];

document.addEventListener("DOMContentLoaded", async () => {
  try {
    await switchTab("national"); 
  } catch (error) {
    console.error("Error loading initial data:", error);
  }
});


/////////////////////////////////////////////////////////////////
const getNcpAndLcp = async (type) => {
  try {
      const userId = document.querySelector("#national-content").getAttribute("data-id");
      
      const url = `backend/api/user-uploaded.php?type=${type}&userid=${userId}`;
      
      const response = await fetch(url, { 
        method: "GET" 
      });
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      
      const text = await response.text();
      
      try {
        const data = JSON.parse(text);
        return data;
      } catch (parseError) {
        console.error("Error parsing JSON:", parseError);
        return [];
      }
  } catch (error) {
      console.error("Error fetching data:", error.message);
      return [];
  }
};


/////////////////////////////////////////////////////////////////
let currentPage = 1;
const rowsPerPage = 10;

const tableData = async (type) => {
  const tableBody = document.querySelector("#table-body");
  tableBody.innerHTML = "";

  const data = ncpAndlcpData;
  if (!data || data.length === 0) {

    const noDataRow = `<tr>
      <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-sm">
        <div class="flex flex-col items-center justify-center space-y-2">
          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <p class="font-medium">No uploads yet!</p>
          <p class="text-gray-400">Your uploaded files will appear here</p>
        </div>
      </td>
    </tr>`;
    tableBody.innerHTML = noDataRow;
    
    // Hide pagination when there's no data
    const paginationControls = document.querySelector("#pagination-controls");
    const showingEntries = document.querySelector("#showing-entries");
    if (paginationControls) paginationControls.innerHTML = "";
    if (showingEntries) showingEntries.textContent = "";
    
    return;
  }

  // Calculate pagination
  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = Math.min(startIndex + rowsPerPage, data.length);
  const currentDisplayData = data.slice(startIndex, endIndex);

  // Populate the table
  currentDisplayData.forEach((item) => {
    let status = item.status;
    let statusClass = ""; 
  
    if (status === 0 || status === null) {
      status = "Pending";
      statusClass = "bg-yellow-100 text-yellow-800";
    } else if (status === 1) {
      status = "Approved";
      statusClass = "bg-green-100 text-green-800";
    } else if (status === 2) {
      status = "Disapproved";
      statusClass = "bg-red-100 text-red-800";
    }
  
    // Get the correct file path based on the type
    let filePath = "";
    if (item.lssfile && item.lsspath) {
      filePath = item.lsspath.replace(/^\.\//, "") + item.lssfile;
    } else if (item.ncpfile && item.ncppath) {
      filePath = item.ncppath.replace(/^\.\//, "") + item.ncpfile;
    }
  
    const row = `<tr>
      <td class="px-6 py-4 whitespace-nowrap text-justify text-sm font-medium text-primary-600">${item.dateuploaded}</td>
      <td class="px-6 py-4 whitespace-nowrap text-justify text-sm text-primary-600 max-w-[300px] truncate">${item.ncpname || item.lssname}</td>
      <td class="px-6 py-4 whitespace-nowrap text-justify text-sm text-primary-600 text-wrap">${item.description}</td>
      <td class="px-6 py-4 whitespace-nowrap text-justify">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
          ${status}
        </span>
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-justify text-right text-sm font-medium">
        ${
          filePath
            ? `<a href="${filePath}" class="text-primary-600 hover:text-primary-400">View</a>`
            : '<span class="text-gray-400">No file</span>'
        }
      </td>
    </tr>`;
    tableBody.innerHTML += row;
  });

  // Update pagination controls
  updatePaginationControls(type, ncpAndlcpData.length);
};

/////////////////////////////////////////////////////////////////

const updatePaginationControls = (type, totalRows) => {
  const paginationControls = document.querySelector("#pagination-controls");
  const showingEntries = document.querySelector("#showing-entries");

  const totalPages = Math.ceil(totalRows / rowsPerPage);
  const startIndex = (currentPage - 1) * rowsPerPage + 1;
  const endIndex = Math.min(startIndex + rowsPerPage - 1, totalRows);

  // Realtime showing "Showing X to Y of Z entries"
  showingEntries.textContent = `Showing ${startIndex} to ${endIndex} of ${totalRows} entries`;

  paginationControls.innerHTML = "";

  paginationControls.innerHTML += `
      <li>
        <button id="prev-page" class="transform transition duration-300 hover:scale-105 px-3 py-1 text-primary-600 bg-white border rounded ${
          currentPage === 1
            ? "cursor-not-allowed opacity-50"
            : "hover:bg-gray-100"
        }" ${currentPage === 1 ? "disabled" : ""}>Previous</button>
      </li>
    `;

  // Para ni sa Page Numbers
  const maxVisiblePages = 5;
  let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
  let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

  // Adjust startPage if hapit na sa last part
  if (endPage - startPage + 1 < maxVisiblePages) {
    startPage = Math.max(1, endPage - maxVisiblePages + 1);
  }

  for (let i = startPage; i <= endPage; i++) {
    paginationControls.innerHTML += `
        <li>
          <button class="page-btn px-3 py-1 border rounded ${
            i === currentPage
              ? "bg-primary-700 text-white"
              : "bg-white text-primary-600 hover:bg-gray-100"
          }" data-page="${i}">${i}</button>
        </li>
      `;
  }

  paginationControls.innerHTML += `
      <li>
        <button id="next-page" class="transform transition duration-300 hover:scale-105 px-3 py-1 text-primary-600 bg-white border rounded ${
          currentPage === totalPages
            ? "cursor-not-allowed opacity-50"
            : "hover:bg-gray-100"
        }" ${currentPage === totalPages ? "disabled" : ""}>Next</button>
      </li>
    `;

  document.getElementById("prev-page")?.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      tableData(type);
    }
  });

  document.getElementById("next-page")?.addEventListener("click", () => {
    if (currentPage < totalPages) {
      currentPage++;
      tableData(type);
    }
  });

  document.querySelectorAll(".page-btn").forEach((button) => {
    button.addEventListener("click", (event) => {
      currentPage = parseInt(event.target.dataset.page);
      tableData(type);
    });
  });
};

/////////////////////////////////////////////////////////////////

const switchTab = async (tab) => {
  currentPage = 1;
  
  // Fetch data based on tab type
  ncpAndlcpData = await getNcpAndLcp(tab === "national" ? "ncp" : "lcp");
  
  if (tab === "national") {
    document
      .getElementById("national-tab")
      .classList.add("text-primary-700", "border-b-2", "border-primary-700");
    document
      .getElementById("local-tab")
      .classList.remove("text-primary-500", "border-b-2", "border-primary-500");
  } else if (tab === "local") {
    document
      .getElementById("local-tab")
      .classList.add("text-primary-700", "border-b-2", "border-primary-700");
    document
      .getElementById("national-tab")
      .classList.remove("text-primary-600", "border-b-2", "border-primary-600");
  }
  
  // Update table with new data
  tableData(tab);
};

const ncpTab = document.getElementById("national-tab");
const lcpTab = document.getElementById("local-tab");

ncpTab.addEventListener("click", () => switchTab("national"));
lcpTab.addEventListener("click", () => switchTab("local"));

switchTab("national");

/////////////////////////////////////////////////////////////////

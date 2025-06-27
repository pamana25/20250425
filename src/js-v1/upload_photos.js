let ncp;
let lcp;
const propertiesUploadForm = document.getElementById("propertiesUpload");
const hasParams = new URLSearchParams(window.location.search);
console.log(hasParams.get("lcpid"));
document.addEventListener("DOMContentLoaded", async function () {
  try {
    // Fetch data from PHP using async/await
    const [ncpResponse, lcpResponse] = await Promise.all([
      fetch("backend/api/ncp.php", { method: "GET" }),
      fetch("backend/api/lcp.php", { method: "GET" }),
    ]);

    if (!ncpResponse.ok || !lcpResponse.ok) {
      throw new Error("One or both network responses were not ok");
    }

    ncp = await ncpResponse.json();
    lcp = await lcpResponse.json();

    if (hasParams) {
      clearAreaOptions();
      categoryOptions();
    }
  } catch (error) {
    console.error("There was a problem with the fetch operation:", error);
  }
});

// Function to handle the POST request
const propertiesUploadApi = async (formData, apiUrl) => {
  showLoadingIndicator()
  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      body: formData, 
    });

    console.log(formData, "sent");

    const data = await response.json();

    if (data.status === "success") {
      sweetAlert(data.status, data.message, data.status);
    } else {
      sweetAlert(data.message, "", data.status);
    }
  } catch (error) {
    console.error(error);
  }finally{
    hideLoadingIndicator()
  }
};

// Add event listener to form submission
propertiesUploadForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  const formData = new FormData(propertiesUploadForm);
  const fullName = formData.get("firstname") + " " + formData.get("lastname");
  const selectBox = document.getElementById("selectBox");

  let apiUrl = "";

  if (category.value === "lss") {
    const getLssid = selectBox.getAttribute("data-id");

    formData.append("lssid", getLssid);
    formData.append("source_name", fullName);
    apiUrl = "backend/api/lcp-user-upload.php";
  } else {
    const getNcpid = selectBox.getAttribute("data-id");

    formData.append("ncpid", getNcpid);
    formData.append("source_name", fullName);
    apiUrl = "backend/api/ncp-user-upload.php";
  }
  // console.log(propertiesUploadForm)
  await propertiesUploadApi(formData, apiUrl);
});

// Start of select with search box
const selectBox = document.getElementById("selectBox");
const optionsContainer = document.getElementById("optionsContainer");
const searchBox = document.getElementById("searchBox");
const groupLabels = document.querySelectorAll(".group-label");
const category = document.getElementById("category");
const selectAreaContainer = document.getElementById("selectAreaContainer");
let triggerOnceParams = false;

category.addEventListener("input", () => {
  clearAreaOptions();
  categoryOptions();
});

const categoryOptions = () => {
  const options = optionsContainer.querySelectorAll(".group-label");
  if (hasParams && !triggerOnceParams) {
    console.log("triggered");
    const lssid = hasParams.get("lcpid");
    const ncpid = hasParams.get("ncpid");
    const id = lssid ?? ncpid;
    // category.value = hasParams.has("lcpid") ? "lss" : "ncp";
    category.value = hasParams.has("lcpid") ? "lss" : (hasParams.has("ncpid") ? "ncp" : "");
    // selectAreaContainer.classList.remove("hidden");
    if (category.value !== "") {
      selectAreaContainer.classList.remove("hidden");
    }
    
    selectBox.setAttribute("data-id", id);
    selectBox.value = hasParams.get("areaname");
    triggerOnceParams = true;
  }
  options.forEach((option) => {
    const optionValue = option.querySelector("#area-options");
    let hasProperties = false;

    if (category.value === "ncp") {
      ncp.map((ncpItem) => {
        if (option.getAttribute("value") == ncpItem.areaid) {
          optionValue.innerHTML += `<div id="ncpid" class='option property px-8 py-2 cursor-pointer bg-white hover:bg-gray-200' data-ncpid='${ncpItem.ncpid}'>${ncpItem.ncpname}</div>`;
          hasProperties = true;
        }
      });
    } else {
      lcp.map((lcpItem) => {
        if (option.getAttribute("value") == lcpItem.areaid) {
          optionValue.innerHTML += `<div id="lssid" class='option property px-8 py-2 cursor-pointer bg-white hover:bg-gray-200' data-lssid='${lcpItem.lssid}'>${lcpItem.lssname}</div>`;
          hasProperties = true;
        }
      });
    }

    if (!hasProperties) {
      optionValue.innerHTML =
        "<div class='bg-white no-properties text-gray-500 px-8 py-2'>No properties enlisted</div>";
    }
  });
};

selectBox.addEventListener("click", function () {
  optionsContainer.classList.toggle("hidden");
  searchBox.classList.toggle("hidden");
  searchBox.focus();
});

searchBox.addEventListener("input", function () {
  const searchValue = searchBox.value.toLowerCase();

  const options = optionsContainer.querySelectorAll(".option, .group-label");

  options.forEach((option) => {
    const optionText = option.textContent.toLowerCase();

    if (optionText.includes(searchValue)) {
      option.style.display = "block";
    } else {
      option.style.display = "none";
    }
  });
});

const clearAreaOptions = () => {
  const areaOptions = document.querySelectorAll("#area-options");
  areaOptions.forEach((option) => {
    option.innerHTML = "";
  });
};

// Function to handle click event
function handlePropertyClick(event) {
  if (
    event.target.classList.contains("option") &&
    event.target.classList.contains("property")
  ) {
    const lssid = event.target.getAttribute("data-lssid");
    const ncpid = event.target.getAttribute("data-ncpid");
    const id = lssid ?? ncpid;
    selectBox.setAttribute("data-id", id); // Store ID in the data attribute
    selectBox.value = event.target.textContent.trim(); // Populate input value with the selected text
    optionsContainer.classList.add("hidden");
    searchBox.classList.add("hidden");
  }
}

optionsContainer.addEventListener("click", handlePropertyClick);

// Close dropdown if clicked outside
document.addEventListener("click", function (event) {
  const optionsContainer = document.getElementById("optionsContainer");
  const searchBox = document.getElementById("searchBox");

  if (!event.target.closest(".custom-select-container")) {
    optionsContainer.classList.add("hidden");
    searchBox.classList.add("hidden");
  }
});

// Call the function on page load to set up the fields
window.onload = function () {
  toggleNameFields();
};
function toggleNameFields() {
  const sourceUrl = document.getElementById("sourceUrl");
  const ownershipCheckbox = document.getElementById("ownership");
  const nameFields = document.getElementById("nameFields");
  const emptyNameFields = document.getElementById("emptynameFields");
  const aliasName = document.getElementById("aliasName");
  const checkalias = document.getElementById("foralias");
  // Get the input fields for first and last name
  const firstNameField = document.getElementById("firstname");
  const lastNameField = document.getElementById("lastname");
  const emptyFirstNameField = document.getElementById("emptyFirstname");
  const emptyLastNameField = document.getElementById("emptyLastname");

  if (ownershipCheckbox.checked) {
    // When the checkbox is checked, show the name fields and disable the empty fields
    nameFields.classList.remove("hidden");
    emptyNameFields.classList.add("hidden");
    sourceUrl.classList.add("hidden");
    checkalias.classList.remove("hidden");
    // Enable the fields in nameFields with the PHP values
    firstNameField.disabled = false;
    lastNameField.disabled = false;
    aliasName.disabled = false;
    // Disable the fields in emptyNameFields
    emptyFirstNameField.disabled = true;
    emptyLastNameField.disabled = true;
  } else {
    // When the checkbox is unchecked, show the empty fields and disable the name fields
    nameFields.classList.add("hidden");
    checkalias.classList.add("hidden");
    emptyNameFields.classList.remove("hidden");
    sourceUrl.classList.remove("hidden");
    // Disable the fields in nameFields
    firstNameField.disabled = true;
    lastNameField.disabled = true;
    aliasName.disabled = true;
    // Enable the fields in emptyNameFields for user input
    emptyFirstNameField.disabled = false;
    emptyLastNameField.disabled = false;
  }
}

function toggleAliasField() {
  const aliasField = document.getElementById("aliasField");
  const checkbox = document.getElementById("useAlias");
  aliasField.classList.toggle("hidden", !checkbox.checked);
}

function toggleCategory() {
  // Get the selected value from the dropdown
  const categorySelect = document.getElementById("category");

  // Check if a value is selected
  if (categorySelect.value) {
    // Show the area selection container
    selectAreaContainer.classList.remove("hidden");
  } else {
    // Hide the area selection container if no value is selected
    selectAreaContainer.classList.add("hidden");
  }
}
function sweetAlert(title = null, text = null, icon = null) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,
    confirmButtonText: "Ok",
  }).then((result) => {
    if (result.isConfirmed && icon === "success") {
      window.location.href = "upload-photos";
    }
  });
}

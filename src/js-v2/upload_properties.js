document.addEventListener("DOMContentLoaded", () => {
  const appendDiv = document.getElementById("append-div");
  // const formSubmit = document.getElementById("formsubmit");
  // let btnLoadingText = document.querySelector(".btn-loading-text");
  const inputs = formsubmit.querySelectorAll('input[type="text"], textarea');
  const divButton = document.createElement("div");
  const buttonElement = `
                            <button type="button" class="btn text-start text-sm ps-0 cbh-color-blue transform transition duration-300 hover:scale-105" type="button" id="add_source_input_btn"><small>Add Source<i class="fa-solid fa-plus"></i></small></button>
                        `;
  divButton.className = "form-group col-12  mb-2 ";

  divButton.innerHTML += buttonElement;

  appendDiv.appendChild(divButton);

  const addSourceBtn = document.getElementById("add_source_input_btn");
  var appendHtml =
    '<div class="w-full mt-2 mb-2 relative" id="added-source-input"><input type="text" name="source_url[]" id="source_url" class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pr-10" required data-placeholer="test"><button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-500 hover:text-gray-700 focus:outline-none" type="button" id="remove_source_input_btn"><i class="fa-solid fa-trash text-primary-600"></i></button></div>';

  addSourceBtn.addEventListener("click", () => {
    appendDiv.removeChild(divButton);
    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = appendHtml;

    appendDiv.append(tempDiv.firstChild);

    appendDiv.appendChild(divButton);
    const removeSourceBtn = document.querySelectorAll(
      "#remove_source_input_btn"
    );
    removeSourceBtn.forEach((btn) => {
      btn.addEventListener("click", () => {
        const divToRemove = btn.closest("#added-source-input");
        divToRemove.remove();
      });
    });
  });

  //form submit validation

  // formSubmit.addEventListener("submit", (e) => {
  //   btnLoadingText.innerHTML = "<strong>LOADING...</strong>";

  //   if (formSubmit.checkValidity() === false) {
  //     e.preventDefault();
  //     btnLoadingText.innerHTML =
  //       '<strong><i class="bi bi-upload me-2 fs-5"></i>UPLOAD</strong>';
  //     formSubmit.classList.add("was-validated");
  //     return false;
  //   }
  // });
  // --------------------------------------------------------------------------
  // Floating label functionality

  inputs.forEach((input) => {
    const wrapper = document.createElement("div");
    wrapper.className = "relative mb-2.5";
    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);

    const label = document.createElement("label");
    label.htmlFor = input.id;
    label.className =
      "absolute left-2 top-2 transition-all duration-200 text-primary-600";
    label.textContent = input.getAttribute("data-placeholder");
    wrapper.appendChild(label);

    const errorSpan = document.createElement("span");
    // errorSpan.style.color = "red";
    errorSpan.className = "error-message text-danger-600 text-xs mt-1 hidden";
    wrapper.appendChild(errorSpan);

    input.addEventListener("focus", () => {
      label.classList.remove("top-2");
      label.classList.add(
        "text-xs",
        "-top-2",
        "bg-white",
        "px-1",
        "text-primary-600"
      );
    });

    input.addEventListener("blur", () => {
      if (!input.value) {
        label.classList.remove(
          "text-xs",
          "-top-2",
          "bg-white",
          "px-1",
          "text-primary-600"
        );
        label.classList.add("top-2");
      }
    });

    if (input.value) {
      label.classList.add(
        "text-xs",
        "-top-2",
        "bg-white",
        "px-1",
        "text-primary-600"
      );
      label.classList.remove("top-2");
    }

    input.placeholder = "";
  });
  //upload properties

  const addpropertyForm = document.getElementById("formsubmit");
  const selectpropertyType = document.getElementById("selectproperties");
  const areaid = document.getElementById("areaid");

  // const registerAPI = async (formData, endpoint) => {
  //   try {
  //     const response = await fetch(endpoint, {
  //       method: "POST",
  //       headers: {
  //         "Content-Type": "application/json",
  //       },
  //       body: JSON.stringify(formData),
  //     });
  //     const data = await response.json();
  //     return data;
  //   } catch (error) {
  //     console.error(error);
  //   }
  // };

  // addpropertyForm.addEventListener("submit", async (event) => {
  //   event.preventDefault();

  //   const formData = new FormData(addpropertyForm);

  //   const officialName = formData.get("official_name");
  //   const localName = formData.get("local_name");
  //   const location = formData.get("location");
  //   const classificationStatus = formData.get("classification_status");
  //   const yearofDeclaration = formData.get("year_declaration");
  //   const otherDeclation = formData.get("other_declaration");
  //   const description = formData.get("description");
  //   const sourceUrl = formData.getAll("source_url[]");
  // const validatePropertyForm = () => {
  //   let isValid = true;
  //   clearErrors();

  //   if (!addpropertyForm.official_name.value.trim()) {
  //     showError(addpropertyForm.official_name, "Official Name is required");
  //     isValid = false;
  //   }

  //   // if (!addpropertyForm.local_name.value.trim()) {
  //   //   showError(addpropertyForm.local_name, "Local Name is required");
  //   //   isValid = false;
  //   // }

  //   if (!addpropertyForm.location.value.trim()) {
  //     showError(addpropertyForm.location, "Location is required");
  //     isValid = false;
  //   }

  //   if (!addpropertyForm.classification_status.value.trim()) {
  //     showError(addpropertyForm.classification_status, "Classification Status is required");
  //     isValid = false;
  //   }

  //   if (!addpropertyForm.source_url.value.trim()) {
  //     showError(addpropertyForm.source_url, "Source is required");
  //     isValid = false;
  //   }

  //   // if (!addpropertyForm.year_declaration.value.trim()) {
  //   //   showError(addpropertyForm.year_declaration, "Year of Declaration is required");
  //   //   isValid = false;
  //   // }

  //   return isValid;
  // };

  const showError = (input, message) => {
    const errorElement = input.parentNode.querySelector(".error-message");
    errorElement.textContent = message;
    errorElement.classList.remove("hidden");
  };

  const clearErrors = () => {
    addpropertyForm.querySelectorAll(".error-message").forEach((error) => {
      error.classList.add("hidden");
    });
  };

  addpropertyForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(addpropertyForm);

    const officialName = formData.get("official_name");
    const localName = formData.get("local_name");
    const location = formData.get("location");
    const classificationStatus = formData.get("classification_status");
    const yearofDeclaration = formData.get("year_declaration");
    const otherDeclation = formData.get("other_declaration");
    const description = formData.get("description");
    const sourceUrl = formData.getAll("source_url[]");

    let propertyData;

    if (selectpropertyType.value === "lss") {
      propertyData = {
        areaid: areaid.value,
        lssname: officialName,
        lssofficialname: officialName,
        lsslocalname: localName,
        lsstownorcity: location,
        lssclassificationstatus: classificationStatus,
        lssyeardeclared: yearofDeclaration,
        lssotherdeclarations: otherDeclation,
        lssdescription: description,
        sourcelink: sourceUrl,
        category: selectpropertyType.value,
      };
    } else {
      propertyData = {
        areaid: areaid.value,
        ncpname: officialName,
        ncpofficialname: officialName,
        ncpfilipinoname: localName,
        ncptownorcity: location,
        ncpclassificationstatus: classificationStatus,
        ncpyeardeclared: yearofDeclaration,
        ncpotherdeclarations: otherDeclation,
        ncpdescription: description,
        sourcelink: sourceUrl,
        category: selectpropertyType.value,
      };
    }

    try {
      const endpoint =
        selectpropertyType.value === "lss"
          ? "backend/api/lcp.php"
          : "backend/api/ncp.php";
      const response = await fetch(endpoint, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(propertyData),
      });
      const data = await response.json();
      if (data.status === "success") {
        sweetAlert(data.status, data.message, data.status);
      } else {
        sweetAlert(data.message, "", data.status);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  });
  function sweetAlert(title = null, text = null, icon = null) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonText: "Ok",
    }).then((result) => {
      if (result.isConfirmed && icon === "success") {
        window.location.href = "upload-properties";
      }
    });
  }
  //   if (selectpropertyType.value === "lss") {
  //     const createLcpProperty = {
  //       areaid: areaid.value,
  //       lssname: officialName,
  //       lssofficialname: officialName,
  //       lsslocalname: localName,
  //       lsstownorcity: location,
  //       lssclassificationstatus: classificationStatus,
  //       lssyeardeclared: yearofDeclaration,
  //       lssotherdeclarations: otherDeclation,
  //       lssdescription: description,
  //       sourcelink: sourceUrl,
  //     };

  //     try {
  //       const response = await fetch("backend/api/lcp.php", {
  //         method: "POST",
  //         headers: {
  //           "Content-Type": "application/json",
  //         },
  //         body: JSON.stringify(createLcpProperty),
  //       });
  //       const data = await response.json();
  //       // if (data.status === "success") {
  //       //   //   sweetAlert(data.status, data.message, data.status);
  //       // } else {
  //       //   //   sweetAlert(data.message, "", data.status);
  //       // }
  //     } catch (error) {
  //       console.error(error);
  //     }
  //   } else {
  //     const createNcpProperty = {
  //       areaid: areaid.value,
  //       ncpname: officialName,
  //       ncpofficialname: officialName,
  //       ncpfilipinoname: localName,
  //       ncptownorcity: location,
  //       ncpclassificationstatus: classificationStatus,
  //       ncpyeardeclared: yearofDeclaration,
  //       ncpotherdeclarations: otherDeclation,
  //       ncpdescription: description,
  //       sourcelink: sourceUrl,
  //     };

  //     try {
  //       const response = await fetch("backend/api/ncp.php", {
  //         method: "POST",
  //         headers: {
  //           "Content-Type": "application/json",
  //         },
  //         body: JSON.stringify(createNcpProperty),
  //       });
  //       const data = await response.json();
  //       // if (data.status === "success") {
  //       //   //   sweetAlert(data.status, data.message, data.status);
  //       // } else {
  //       //   //   sweetAlert(data.message, "", data.status);
  //       // }
  //     } catch (error) {
  //       console.error(error);
  //     }
  //   }
  // });
});

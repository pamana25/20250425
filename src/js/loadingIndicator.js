// const showLoadingIndicator = async() => {
//     // Create the dialog element
//     const indicatorDialog = document.createElement('dialog');
//     indicatorDialog.id = "loading-indicator";
//     indicatorDialog.className = "fixed inset-0 flex items-center rounded-full justify-center "; // Tailwind for centering and background
//     // bg-black bg-opacity-30
//     // Define the loading indicator HTML
//     const indicatorString = `
//       <button type="button" class="bg-indigo-500 text-white font-medium rounded-lg px-5 py-2.5 text-sm flex items-center" disabled>
//         <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
//           <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
//           <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
//         </svg>
//         Loading...
//       </button>
//     `;
//     // Add the indicator HTML to the dialog
//     indicatorDialog.innerHTML = indicatorString;
  
//     // Append the dialog to the body and show it
//     document.body.append(indicatorDialog);
//     indicatorDialog.showModal();
  
//     return indicatorDialog; 
//   };
//   const hideLoadingIndicator =()=>{
//     const dialog = document.querySelector('#loading-indicator')
//     dialog.remove()
//   }


// const showLoadingIndicator = async () => {
//     // Create the div element
//     const indicatorDiv = document.createElement('div');
//     indicatorDiv.id = "loading-indicator";
//     indicatorDiv.className = "fixed inset-0 flex items-center justify-center bg-white bg-opacity-50"; // Tailwind for centering and background with slight opacity
  
//     // Define the loading indicator HTML
//     const indicatorString = `
//       <button type="button" class="bg-indigo-500 text-white font-medium rounded-lg px-5 py-2.5 text-sm flex items-center" disabled>
//         <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
//           <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
//           <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
//         </svg>
//         Loading...
//       </button>
//     `;
  
//     // Add the indicator HTML to the div
//     indicatorDiv.innerHTML = indicatorString;
  
//     // Append the div to the body and show it
//     document.body.append(indicatorDiv);
  
//     return indicatorDiv; 
//   };
  
//   const hideLoadingIndicator = () => {
//     const div = document.querySelector('#loading-indicator');
//     if (div) {
//       div.remove();
//     }
//   };





function showLoadingIndicator() {
    const loadingSpinner = document.createElement('div');
    loadingSpinner.id = 'loadingSpinner';
    loadingSpinner.style.position = 'fixed';
    loadingSpinner.style.top = '0';
    loadingSpinner.style.left = '0';
    loadingSpinner.style.width = '100%';
    loadingSpinner.style.height = '100%';
    loadingSpinner.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
    loadingSpinner.style.display = 'flex';
    loadingSpinner.style.justifyContent = 'center';
    loadingSpinner.style.alignItems = 'center';
    loadingSpinner.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 100 100" fill="none">
        <circle cx="50" cy="50" r="35" stroke="#164c70" stroke-width="10" stroke-dasharray="164.93361431346415 56.97787143782138" transform="rotate(56.188 50 50)">
          <animateTransform
            attributeName="transform"
            type="rotate"
            repeatCount="indefinite"
            dur="1s"
            values="0 50 50;360 50 50"
            keyTimes="0;1">
          </animateTransform>
        </circle>
      </svg>
    `;
    document.body.appendChild(loadingSpinner);
  }

  function hideLoadingIndicator() {
    const loadingSpinner = document.getElementById('loadingSpinner');
    if (loadingSpinner) {
      loadingSpinner.remove();
    }
  }




  
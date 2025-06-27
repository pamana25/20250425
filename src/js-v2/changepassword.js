document.addEventListener("DOMContentLoaded", () => {
  const changePassButton = document.getElementById("changePassButton");
  changePassButton.addEventListener("click", async (e) => {
    e.preventDefault();
    const { value: password } = await Swal.fire({
      title: "Change Password",
      html: `
    <div class="relative mb-4">
        <input type="password" id="current_password" class="swal2-input w-96 focus:outline-none focus:ring-2 focus:ring-primary-700" placeholder="Current Password">
        <button type="button" id="showCurrentPassword" class="bg-transparent absolute top-0 right-2 bottom-0 text-gray-500 hover:text-gray-700">
        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>
        </svg>
        </button>
    </div>
    <div class="relative mb-4">
        <input type="password" id="new_password" class="swal2-input w-96 focus:outline-none focus:ring-2 focus:ring-primary-700" placeholder="New Password">
        <button type="button" id="showChangePassword" class="bg-transparent absolute top-0 right-2 bottom-0 text-gray-500 hover:text-gray-700">
        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>
        </svg>
        </button>
    </div>
    <div class="relative">
        <input type="password" id="confirm_password" class="swal2-input w-96 focus:outline-none focus:ring-2 focus:ring-primary-700" placeholder="Confirm Password">
        <button type="button" id="showConfirmPassword" class="bg-transparent absolute top-0 right-2 bottom-0 text-gray-500 hover:text-gray-700">
        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>
        </svg>
        </button>
    </div>`,
      customClass: {
        container: "change-password-modal",
      },
      showCancelButton: true,
      color: "#164c70",
      confirmButtonColor: "#164c70",
      confirmButtonText: "Change Password",
      color: "#164c70",
      showLoaderOnConfirm: true,
      preConfirm: () => {
        const current_password = document
          .getElementById("current_password")
          .value.trim();
        const password = document.getElementById("new_password").value.trim();
        const confirm_password = document
          .getElementById("confirm_password")
          .value.trim();
        const userid = document.getElementById("userid").value;

        const passwordRegex =
          /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

        if (
          !passwordRegex.test(password) ||
          !passwordRegex.test(confirm_password)
        ) {
          Swal.showValidationMessage(
            "Password must be aleast 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character."
          );
          return false;
        }

        if(current_password == password) {
        Swal.showValidationMessage(
            "The password must not be the same as the current password."
          );
          return false;
        }
        if(confirm_password !== password) {
          Swal.showValidationMessage(
              "The password and confirm password do not match."
            );
            return false;
          }

        return {
          current_password,
          password,
          confirm_password,
          change_password: true,
          userid,
        };
      },
    });

    if (password) {
      await changePassAPI(password);
    }
  });

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  const changePassAPI = async (password) => {
    try {
      const response = await fetch("backend/api/user.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(password),
        origin: "same-origin",
      });

      const text = await response.text();

      const data = JSON.parse(text);
      //   const data = await response.json();
      if (data.status === "success") {
        sweetAlert(data.status, data.message, data.status);
        return;
      }
      sweetAlert(data.status, data.message, data.status);
    } catch (error) {
      console.error(error);
      sweetAlert("Error", "Something went wrong", "error");
    }
  };

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Event listeners for password visibility toggles
  document.addEventListener("click", (e) => {
    if (e.target.closest("#showCurrentPassword")) {
      const input = document.getElementById("current_password");
      const type = input.type === "password" ? "text" : "password";
      input.type = type;
      toggleEyeIcon(e.target.closest("button"));
    }

    if (e.target.closest("#showChangePassword")) {
      const input = document.getElementById("new_password");
      const type = input.type === "password" ? "text" : "password";
      input.type = type;
      toggleEyeIcon(e.target.closest("button"));
    }

    if (e.target.closest("#showConfirmPassword")) {
      const input = document.getElementById("confirm_password");
      const type = input.type === "password" ? "text" : "password";
      input.type = type;
      toggleEyeIcon(e.target.closest("button"));
    }
  });

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // This is a function to toggle the eye icon
  function toggleEyeIcon(button) {
    const svg = button.querySelector("svg");
    if (svg) {
      const currentPath = svg.querySelector("path").getAttribute("d");
      const isVisible = currentPath.startsWith("M288");

      if (isVisible) {
        // Switch to hidden eye icon
        svg
          .querySelector("path")
          .setAttribute(
            "d",
            "M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"
          );
      } else {
        // Switch to visible eye icon
        svg
          .querySelector("path")
          .setAttribute(
            "d",
            "M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"
          );
      }
    }
  }

  //This function is for Sweet Alert
  function sweetAlert(title = null, text = null, icon = null) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonText: "Ok",
    }).then((result) => {
      if (result.isConfirmed && icon === "success") {
        window.location.href = "login";
      }
    });
  }
});

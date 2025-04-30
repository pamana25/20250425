//burger menu for areas

const section1_content = document.querySelector("#section1-content");
const animated_icon1 = document.querySelector(".animated-icon1");
const first_button = document.querySelector("#burgerbtn");

first_button.addEventListener("click", () => {
  animated_icon1.classList.toggle("open"); //icon animation
  section1_content.classList.toggle("z-index-1044"); //burger content index
});

// checkemail
const emailInput = document.getElementById("email");
const emailStatus = document.getElementById("checktest");
if (emailInput != null && emailStatus != null) {
  emailInput.addEventListener("blur", function () {
    const email = this.value;
    if (!email) {
      emailStatus.innerHTML = "";
      return;
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        emailStatus.style.display = "block";
        emailStatus.innerHTML = this.responseText;
      }
    };

    xhttp.open("POST", "_db/functions.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(`email=${encodeURIComponent(email)}`);
  });
}
//checkusername
const usernameInput = document.getElementById("username");
const usernameStatus = document.getElementById("checkuser");
if (usernameInput != null && usernameStatus != null) {
  usernameInput.addEventListener("blur", function () {
    const username = this.value;
    if (!username) {
      usernameStatus.innerHTML = "";
      return;
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        usernameStatus.style.display = "block";
        usernameStatus.innerHTML = this.responseText;
      }
    };

    xhttp.open("POST", "_db/functions.php");
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(`username=${encodeURIComponent(username)}`);
  });
}
// password validation
const passwordInput = document.getElementById("password");
const passwordConfirmInput = document.getElementById("confirmpassword");
const passwordStatus = document.getElementById("password-status");
if (passwordInput != null && passwordStatus != null) {
  function validatePassword() {
    const password = passwordInput.value;
    const passwordConfirm = passwordConfirmInput.value;

    if (password.length < 8) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML = "Password must be at least 8 characters long.";
      return false;
    } else if (!/\d/.test(password)) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML = "Password must contain at least one number.";
      return false;
    } else if (password.indexOf(" ") !== -1) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML = "Password cannot contain spaces. ";
    } else if (!/[a-z]/.test(password)) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML =
        "Password must contain at least one lowercase letter.";
      return false;
    } else if (!/[A-Z]/.test(password)) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML =
        "Password must contain at least one uppercase letter.";
      return false;
    } else if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML =
        "Password must contain at least one special character (!@#$%^&*()_+-=[]{};':\"\\|,.<>/?).";
      return false;
    } else if (password !== passwordConfirm) {
      passwordStatus.style.color = "";
      passwordStatus.innerHTML = "Password and confirm password must match.";
      return false;
    } else {
      passwordStatus.style.color = "green";
      passwordStatus.innerHTML = "Password Matched.";
      return true;
    }
  }

  passwordInput.addEventListener("input", validatePassword);
  passwordConfirmInput.addEventListener("input", validatePassword);
}

// upload file javascript
const select_ncp = document.querySelector(".ncp");
const select_lss = document.querySelector(".lss");
const show_ncp = document.querySelector("#show_ncp");
const show_lss = document.querySelector("#show_lss");
const keyupshow = document.querySelector("#keyupshow");
if (keyupshow != null) {
  keyupshow.addEventListener("change", () => {
    if (keyupshow.value == "ncp") {
      show_ncp.style.display = "block";
      show_lss.style.display = "none";
    } else if (keyupshow.value == "lss") {
      show_lss.style.display = "block";
      show_ncp.style.display = "none";
    }
  });
}
//upload file size validation
// Set the maximum file size in bytes
const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// Get the file input element and the submit button
const fileInput = document.getElementById("file");
if (fileInput != null) {
  const submitButton = document.getElementById("upload_btn");

  // Add an event listener to the file input element to check the file size
  fileInput.addEventListener("change", function () {
    // Get the selected file
    const file = this.files[0];

    // Check the file size
    if (file.size > MAX_FILE_SIZE) {
      Swal.fire({
        title: "File size limit!",
        text: "File size upload limit is 5MB or 5242880 bytes.",
        icon: "warning",
      });
      // Disable the submit button to prevent the form from being submitted
      submitButton.disabled = true;
    } else {
      // Enable the submit button if the file is within the size limit
      submitButton.disabled = false;
    }
  });
}

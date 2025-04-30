document.addEventListener('DOMContentLoaded', () => {
    const resetPassForm = document.getElementById('resetPassForm');

    const url = new URL(window.location.href);

    const resetPassAPI = async (formData) => {
        try {
            const response = await fetch("backend/api/user.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            const data = await response.json();
            if (data.status === "success") {
              sweetAlert(data.status, data.message, data.status);
            } else {
              sweetAlert(data.message, "", data.status);
            }
          } catch (error) {
            console.error(error);
          }
    };

    resetPassForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const token = url.searchParams.get("token");
        const formData = new FormData(resetPassForm);
        const password = formData.get("password")
        const confirm_password = formData.get("confirmPassword");
        const resetPassData = {
            token: token,
            password: password,
            confirm_password: confirm_password,
            reset_password: true
        };
        await resetPassAPI(resetPassData);
    });
    
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//This for the declarations
const showPasswordBtn = document.getElementById('showpassword');
const passwordInput = document.getElementById('password');
const showConfirmPasswordBtn = document.getElementById('showConfirmPassword');
const confirmPasswordInput = document.getElementById('confirmPassword');    
const eyeIconpassword = showPasswordBtn.querySelector('svg');
const eyeIconconfirmpassword = showConfirmPasswordBtn.querySelector('svg');
const inputs = document.querySelectorAll(
    '#resetPassForm input[type="password"]'
  );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//This is for the eye icon
showPasswordBtn.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIconpassword.innerHTML = '<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>';
    } else {
        passwordInput.type = 'password';
        eyeIconpassword.innerHTML = '<path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>';
    }
});

showConfirmPasswordBtn.addEventListener('click', () => {
    if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        eyeIconconfirmpassword.innerHTML = '<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>';
    } else {
        confirmPasswordInput.type = 'password';
        eyeIconconfirmpassword.innerHTML = '<path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>';
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//This is for the password validation

function validatePassword(password) {
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (!password) {
        return "Password is required";
    }
    if (password.length < minLength) {
        return "Password must be at least 8 characters long";
    }
    if (!hasUpperCase) {
        return "Password must contain at least one uppercase letter";
    }
    if (!hasLowerCase) {
        return "Password must contain at least one lowercase letter";
    }
    if (!hasNumbers) {
        return "Password must contain at least one number";
    }
    if (!hasSpecialChar) {
        return "Password must contain at least one special character";
    }
    return "valid";
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Para ni sa Real-time password validation feedback
document.getElementById('password').addEventListener('input', function() {
    const password = this.value.trim();
    const validationResult = validatePassword(password);
    const validationMessage = document.getElementById('password-validation-message');
    
    if (validationResult === "valid") {
        this.classList.remove('border-red-500');
        this.classList.add('border-green-500');
        validationMessage.textContent = "Password meets all requirements";
        validationMessage.classList.remove('text-red-500');
        validationMessage.classList.add('text-green-500');
    } else {
     this.classList.remove('border-green-500');
        this.classList.add('border-red-500');
        validationMessage.textContent = validationResult;
        validationMessage.classList.remove('text-green-500');
        validationMessage.classList.add('text-red-500');
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
//This function is for Sweet Alert
  function sweetAlert(title = null, text = null, icon = null) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonText: "Ok",
      confirmButtonColor: "#164c70",
      color: "#164c70",
    }).then((result) => {
      if (result.isConfirmed && icon === "success") {
        window.location.href = "login";
      }
    });
  }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
        errorSpan.className = "error-message text-danger-600 text-xs mt-1 hidden";
        wrapper.appendChild(errorSpan);
    
        input.addEventListener("focus", () => {
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
        }
    
        input.placeholder = "";
      });
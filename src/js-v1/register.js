document.addEventListener("DOMContentLoaded", () => {
  const registerForm = document.getElementById("formRegister");
  const inputs = registerForm.querySelectorAll(
    'input[type="text"], input[type="email"], input[type="password"]'
  );

  const registerAPI = async (formData) => {
    try {
      const response = await fetch("backend/api/user.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
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

  // Form validation
  const validateForm = () => {
    let isValid = true;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex =
      /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

    if (!registerForm.firstname.value.trim()) {
      showError(registerForm.firstname, "First name is required");
      isValid = false;
    }

    if (!registerForm.lastname.value.trim()) {
      showError(registerForm.lastname, "Last name is required");
      isValid = false;
    }

    if (!emailRegex.test(registerForm.email.value)) {
      showError(registerForm.email, "Please enter a valid email address");
      isValid = false;
    }

    if (!registerForm.username.value.trim()) {
      showError(registerForm.username, "Username is required");
      isValid = false;
    }

    if (!passwordRegex.test(registerForm.password.value)) {
      showError(
        registerForm.password,
        "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character"
      );
      isValid = false;
    }

    if (registerForm.password.value !== registerForm.cpassword.value) {
      showError(registerForm.cpassword, "Passwords do not match");
      isValid = false;
    }

    return isValid;
  };

  const showError = (input, message) => {
    const errorElement = input.parentNode.querySelector(".error-message");
    errorElement.textContent = message;
    errorElement.classList.remove("hidden");
  };

  const clearErrors = () => {
    registerForm
      .querySelectorAll(".error-message")
      .forEach((error) => error.classList.add("hidden"));
  };

  registerForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    clearErrors();

    if (validateForm()) {
      const formData = new FormData(registerForm);
      formData.append("register", true);
      const registerData = Object.fromEntries(formData.entries());
      await registerAPI(registerData);
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
        window.location.href = "login";
      }
    });
  }

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
    }

    input.placeholder = "";
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.getElementById("navbar");
  const logo = document.getElementById("logo");
  const currentIndex = window.location.href;
  // const originUrl = window.origin;
  const originUrl = window.location.protocol + "//" + window.location.host;
  // const fixNavPages = [
  //   "http://localhost/_/pamana/",
  //   "https://localhost/_/pamana/",
  //   "https://localhost/_/pamana/#about-us",
  //   "http://192.168.1.10/_/pamana/",
  //   "https://pamana.org/",
  //   originUrl + "/",
  //   originUrl + "/#",
  //   originUrl + "/#about-us",
  //   originUrl,
  // ];

  const fixNavPages = [
    "http://localhost/pamana25/",
    "https://localhost/pamana25/",
    "https://localhost/pamana25/#about-us",
    "http://192.168.1.10/pamana25/",
    "https://pamana.org/",
    originUrl + "/",
    originUrl + "/#",
    originUrl + "/#about-us",
    originUrl,
  ];

  // const isFixNavPage = fixNavPages.includes(currentIndex);
  var isFixNavPage = fixNavPages.indexOf(currentIndex) !== -1;
  // console.log(currentIndex , originUrl,'true dapat');

  isFixNavPage
    ? (navbar.className =
        "fixed top-0 left-0 right-0 z-50 bg-transparent text-white shadow-sm")
    : (navbar.className = "bg-white text-primary-600 shadow-sm border-b");

  // navbar.className =
  //   "fixed top-0 left-0 right-0 z-50 bg-transparent text-white";

  logo.style.filter = isFixNavPage
    ? "brightness(0) invert(1)"
    : "brightness(0) saturate(100%) invert(20%) sepia(16%) saturate(6291%) hue-rotate(180deg) brightness(92%) contrast(83%)";

  // Navbar scroll effect
  window.addEventListener("scroll", function () {
    if (isFixNavPage) {
      if (window.scrollY > 50) {
        navbar.classList.add("bg-black", "bg-opacity-80", "bg-black-80");
        navbar.classList.remove("bg-transparent");
      } else {
        navbar.classList.remove("bg-primary-600", "bg-opacity-80");
        navbar.classList.add("bg-transparent");
      }
    } else {
      if (window.scrollY > 50) {
        navbar.classList
          .add
          // "fixed",
          // "top-0",
          // "left-0",
          // "right-0",
          // "z-50",
          // "bg-opacity-80"
          ();
      } else {
        navbar.classList
          .remove
          // "fixed",
          // "top-0",
          // "left-0",
          // "right-0",
          // "z-50",
          // "bg-opacity-80"
          ();
      }
    }
  });

  // Burger menu toggle
  const burgerBtn = document.getElementById("burgerBtn");
  const burgerMenu = document.getElementById("burgerMenu");
  const burgerOverlay = document.getElementById("burgerOverlay");

  // Check if elements are found
  if (!burgerBtn || !burgerMenu || !burgerOverlay) {
    console.error("Burger menu elements not found!");

    return;
  }

  burgerBtn.addEventListener("click", () => {
    burgerMenu.classList.toggle("-translate-x-full");
    burgerOverlay.classList.toggle("opacity-0");
    burgerOverlay.classList.toggle("opacity-70");

    burgerOverlay.classList.toggle("pointer-events-none");
    document.body.classList.toggle("overflow-hidden");
  });

  burgerOverlay.addEventListener("click", () => {
    burgerMenu.classList.add("-translate-x-full");
    burgerOverlay.classList.add("opacity-0", "pointer-events-none");
    burgerOverlay.classList.remove("opacity-70");

    document.body.classList.remove("overflow-hidden");
  });

  // Mobile menu toggle
  const ellipsesMenuBtn = document.getElementById("ellipsesMenuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  ellipsesMenuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("translate-x-full");
  });

  // Search functionality (placeholder)
  const searchBtn = document.getElementById("searchBtn");
  searchBtn.addEventListener("click", () => {
    alert("Search functionality to be implemented");
  });



  if (isFixNavPage) {
    // Carousel data
    var carouselItems = [
      {
        title:
          "Metropolitan Cathedral and Parish Church of Saint Vitalis and of the Guardian Angels of Cebu",
        description:
          "Cebu City | Marked Structure, National Historical Commission of the Philippines (NHCP)",
        image:
          "assets/images/hero-image/462562021_1751635925638469_6599799741384326206_n.jpg",
        // source: "Marian Bas, Constant Motion Studio, © 2025"
      },
      {
        title: "Parish Church of Santa Rosa de Lima of Daanbantayan",
        description: "Daanbantayan | Classified Historic Structure",
        image: "assets/images/hero-image/a2.jpg",
        // source: "Brayan Anunciado, Constant Motion Studio, © 2025"
      },
      {
        title: "Parish Church of Saints Peter and Paul of Bantayan",
        description: "Bantayan, Cebu | Classified Historic Structure",
        image: "assets/images/hero-image/IMG_7814.jpg",
        // source: "Ben Medina, Constant Motion Studio, © 2025"
      },
      {
        title: "Casa Gorordo",
        description:
          "Cebu City | National Historical Landmark, National Historical Commission of the Philippines (NHCP)",
        image: "assets/images/hero-image/IMG_1240.jpg",
        // source: "Marian Bas, Constant Motion Studio, © 2025"
      },
      {
        title: "Heritage of Cebu Monument",
        description: "Cebu City | Registered Property",
        // image: "assets/images/hero-image/IMG_1361.jpg",
        image: "assets/images/hero-image/chs-1-1.jpeg",
        // source: "Ben Medina, Constant Motion Studio, © 2025"
      },
      {
        title: "Parish Church of Santo Ni\u00f1o of Santa Fe",
        description: "Santa Fe, Cebu | Classified Historic Structure",
        image:
          "assets/images/hero-image/Parish_Church_of_Santo_Nino_Santa_Fe.jpg",
        // source: "Marian Bas, Constant Motion Studio, © 2025"
      },
    ];

    // DOM Elements
    var carouselItemsContainer = document.getElementById(
      "carouselItemsContainer"
    );
    var prevBtn = document.getElementById("prevBtn");
    var nextBtn = document.getElementById("nextBtn");
    var dotsContainer = document.getElementById("dotsContainer");
    var currentSlide = 0;
    var slideInterval;

    // Function to create carousel items
    function createCarouselItems() {
      for (var i = 0; i < carouselItems.length; i++) {
        var item = carouselItems[i];
        var slide = document.createElement("div");
        slide.className =
          "w-full h-full flex-shrink-0 bg-cover bg-center relative";

        var img = document.createElement("img");
        img.src = item.image;
        img.className = "absolute inset-0 w-full h-full object-cover";
        slide.appendChild(img);
        // slide.style.backgroundImage = 'url("' + item.image + '")';
        var overlay = document.createElement("div");
        overlay.className =
          "absolute w-full h-full inset-0 bg-black-30 flex flex-col items-center justify-center";
        var contentContainer = document.createElement("div");
        contentContainer.className =
          "bottom-8 absolute bottom-20 left-4 sm:left-16";

        var title = document.createElement("h2");
        title.className =
          "text-3xl sm:text-4xl md:text-5xl font-semibold text-white mb-4 whitespace-wrap pr-8";
        title.textContent = item.title;

        var description = document.createElement("p");
        description.className = "text-sm sm:text-base text-white mb-1";
        description.textContent = item.description;

        var source = document.createElement("p");
        source.className = "text-sm text-white";
        source.textContent = item.source;
        

        contentContainer.appendChild(title);
        contentContainer.appendChild(description);
        contentContainer.appendChild(source);
        overlay.appendChild(contentContainer);
        slide.appendChild(overlay);
        carouselItemsContainer.appendChild(slide);
      }
    }

    // Function to show the current slide
    function showSlide(index) {
      var totalSlides = carouselItems.length;
      carouselItemsContainer.style.transform =
        "translateX(-" + index * 100 + "%)";
      // Update dots
      var dots = dotsContainer.children;
      for (var i = 0; i < dots.length; i++) {
        if (i === index) {
          dots[i].classList.add("bg-white");
          dots[i].classList.remove("bg-gray-400");
        } else {
          dots[i].classList.remove("bg-white");
          dots[i].classList.add("bg-gray-400");
        }
      }
    }

    // Function to create dots for the carousel
    function createDots() {
      for (var index = 0; index < carouselItems.length; index++) {
        var dot = document.createElement("span");
        dot.className =
          "w-3 h-3 " +
          (index === 0 ? "bg-white" : "bg-gray-400") +
          " rounded-full cursor-pointer";
        dot.addEventListener(
          "click",
          (function (index) {
            return function () {
              currentSlide = index;
              showSlide(currentSlide);
            };
          })(index)
        );
        dotsContainer.appendChild(dot);
      }
    }

    function startSlideInterval() {
      slideInterval = setInterval(function () {
        currentSlide = (currentSlide + 1) % carouselItems.length;
        showSlide(currentSlide);
      }, 8000);
    }

    // Function to stop the automatic slide change
    function stopSlideInterval() {
      clearInterval(slideInterval);
    }

    // Function to reset the slide interval
    function resetSlideInterval() {
      stopSlideInterval(); // Stop the current interval
      startSlideInterval(); // Start a new interval
    }

    // Event listeners for buttons
    prevBtn.addEventListener("click", function () {
      currentSlide =
        (currentSlide - 1 + carouselItems.length) % carouselItems.length;
      showSlide(currentSlide);
      resetSlideInterval(); // Reset the timer
    });

    nextBtn.addEventListener("click", function () {
      currentSlide = (currentSlide + 1) % carouselItems.length;
      showSlide(currentSlide);
      resetSlideInterval(); // Reset the timer
    });

    // Initialize the carousel
    createCarouselItems();
    createDots();
    showSlide(currentSlide);
    startSlideInterval();

    // Add mouse event listeners to pause/resume the slide interval
    carouselItemsContainer.addEventListener("mouseenter", stopSlideInterval);
    carouselItemsContainer.addEventListener("mouseleave", startSlideInterval);
  }

  //for back to top and scroll indicator
  const backToTopBtnIndicator = document.createElement("button");
  backToTopBtnIndicator.id = "to-top-button";
  backToTopBtnIndicator.className =
    "md:flex items-center justify-center w-14 h-14 bg-primary-700 text-white rounded-full shadow-lg fixed bottom-10 left-1/2 transform -translate-x-1/2 hover:bg-primary-800";
  backToTopBtnIndicator.innerHTML = `<i class="fa-solid fa-chevron-up text-2xl"></i>
<span class="sr-only">Go to top</span>`;
  backToTopBtnIndicator.title = "Back to top";
  document.body.appendChild(backToTopBtnIndicator);

  backToTopBtnIndicator.addEventListener("click", function () {
    console.log('clicked');
    // document.getElementById("navbar").scrollIntoView({ top: 0,behavior: "smooth" });
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  const scrollBtnIndicator = document.createElement("button");
  scrollBtnIndicator.id = "scrollDownBtn";
  scrollBtnIndicator.innerHTML = `<i class="fas fa-chevron-down text-2xl"></i>`;
  scrollBtnIndicator.className =
    "flex items-center justify-center w-14 h-14 bg-primary-700 text-white rounded-full shadow-lg absolute bottom-10 left-1/2 transform -translate-x-1/2 hover:bg-primary-800";
  scrollBtnIndicator.title = "Scroll down to see more";
  document.body.appendChild(scrollBtnIndicator);

  scrollBtnIndicator.addEventListener("click", function () {
    // document.getElementById("about-us").scrollIntoView({ behavior: "smooth" });
    window.scrollTo({ top: 450, behavior: "smooth" });
  });

  // if (
  //   window.location.href === "https://www.pamana.org/login" ||
  //   originUrl + "/login" ||
  //   originUrl + "/signup"
  // ) {
  //   document.body.removeChild(scrollBtnIndicator);
  //   document.body.removeChild(backToTopBtnIndicator);
  // }
  window.addEventListener("scroll", function () {
    if (this.window.scrollY > 0) {
      backToTopBtnIndicator.classList.remove("hidden");
      backToTopBtnIndicator.style.pointerEvents = "auto";
      scrollBtnIndicator.classList.add("hidden");
      scrollBtnIndicator.classList.remove("flex");
    } else {
      backToTopBtnIndicator.classList.add("hidden");
      backToTopBtnIndicator.style.pointerEvents = "none";
      scrollBtnIndicator.classList.add("flex");
      scrollBtnIndicator.classList.remove("hidden");
    }
  });
});
// // Get the 'to top' button element by ID
// var toTopButton = document.getElementById("to-top-button");

// // Check if the button exists
// if (toTopButton) {
//   // On scroll event, toggle button visibility based on scroll position
//   window.onscroll = function () {
//     if (
//       document.body.scrollTop > 100 ||
//       document.documentElement.scrollTop > 100
//     ) {
//       toTopButton.classList.remove("hidden");
//     } else {
//       toTopButton.classList.add("hidden");
//     }
//   };

//   // Function to scroll to the top of the page smoothly
//   window.goToTop = function () {
//     window.scrollTo({
//       top: 0,
//       behavior: "smooth",
//     });
//   };
//   // Center the 'To Top' button
//   toTopButton.style.left = "50%";
//   toTopButton.style.transform = "translateX(-50%)";
// }

// if (backToTopBtnIndicator) {

// }

// scrollBtnIndicator.addEventListener("mouseenter", () => {
//   const tooltip = document.createElement("div");
//   tooltip.innerText = "Scroll down to see more";
//   tooltip.classList.add("tooltip-box");
//   document.body.appendChild(tooltip);

//   // Position tooltip near the button
//   const rect = scrollBtnIndicator.getBoundingClientRect();
//   tooltip.style.left = `${rect.left + rect.width / 2}px`;
//   tooltip.style.top = `${rect.top - 30}px`;

//   scrollBtnIndicator.dataset.tooltipId = tooltip; // Store reference for removal
// });
// Function to show/hide button based on scroll position

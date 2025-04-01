// Toggle mobile menu
const menuToggle = document.querySelector(".menu-toggle");
const menu = document.querySelector(".menu");

menuToggle.addEventListener("click", () => {
  menu.classList.toggle("show");
});

// Handle newsletter form submission
const newsletterForm = document.querySelector(".newsletter-form");
newsletterForm.addEventListener("submit", (e) => {
  e.preventDefault();
  alert("Thank you for subscribing to DAFI Scholarship updates!");
  newsletterForm.reset();
});

// Reveal elements on scroll with faster immediate effect
document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll(".reveal");

    function revealOnScroll() {
        elements.forEach(element => {
            if (element.getBoundingClientRect().top < window.innerHeight - 50) {
                element.classList.add("visible");
            }
        });
    }

    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
});

// FAQ toggle functionality
document.querySelectorAll(".faq-item").forEach(item => {
    item.addEventListener("click", () => {
        let answer = item.querySelector(".answer");
        let arrow = item.querySelector(".arrow");

        if (answer.style.display === "block") {
            answer.style.display = "none";
            arrow.style.transform = "rotate(0deg)";
        } else {
            answer.style.display = "block";
            arrow.style.transform = "rotate(180deg)";
        }
    });
});


function toggleScholarship(id) {
  // Hide all detail sections
  document.querySelectorAll('[id^="about-scholarship-"]').forEach(function(section) {
    section.style.display = "none";
  });
  // Show the section corresponding to the clicked scholarship
  var detailsSection = document.getElementById("about-scholarship-" + id);
  if (detailsSection) {
    detailsSection.style.display = "block";
    detailsSection.scrollIntoView({ behavior: 'smooth' });
  }
}



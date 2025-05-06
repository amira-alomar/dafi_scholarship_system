// Function to filter opportunities
function filterOpportunities(category) {
    let cards = document.querySelectorAll(".opportunity-card");
    let tabs = document.querySelectorAll(".tab");

    // Update active tab
    tabs.forEach(tab => tab.classList.remove("active"));
    document.querySelector(`[onclick="filterOpportunities('${category}')"]`).classList.add("active");

    // Show/hide cards based on category
    cards.forEach(card => {
        let cardCategory = card.getAttribute("data-category");

        if (category === "all" || cardCategory === category) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}
// Open the Apply Form and Pre-fill Data
function openApplyForm(title) {
    document.getElementById("applyFormOverlay").style.display = "flex";
    document.getElementById("opportunity").value = title;
}

// Close the Apply Form
function closeApplyForm() {
    document.getElementById("applyFormOverlay").style.display = "none";
}
setTimeout(function () {
    var message = document.getElementById('flash-message');
    if (message) {
        message.style.display = 'none';
    }
}, 5000); // الوقت بالملي ثانية (3000 = 3 ثواني)
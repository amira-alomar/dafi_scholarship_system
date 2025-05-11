
        // Toast notification
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Modal functions
 function openModal(title, location, details, method, company, deadline, width, skills) {
    const modal = document.getElementById('modal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-location').textContent = location;
    document.getElementById('modal-description').textContent = details;
    document.getElementById('modal-app').textContent = method;
    document.getElementById('modal-company').textContent = company;
    document.getElementById('modal-deadline').textContent = deadline;
    document.getElementById('modal-progress').style.width = width;
    document.getElementById('modal-skills').textContent = skills;
}



        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.querySelectorAll('.view-details').forEach(button => {
    button.addEventListener('click', () => {
        const title = button.dataset.title;
        const location = button.dataset.location;
        const description = button.dataset.description;
        const method = button.dataset.method;
        const company = button.dataset.company;
        const deadline = button.dataset.deadline;
        const width = button.dataset.width;
        const skills = button.dataset.skills;

        openModal(title, location, description, method, company, deadline, width, skills);
    });
});

function searchJobs() {
    const query = document.getElementById("skills").value.toLowerCase().trim();
    const jobCards = document.querySelectorAll(".job-card");

    jobCards.forEach(card => {
        const title = card.getAttribute("data-title");
        const description = card.getAttribute("data-description");
        const location = card.getAttribute("data-location");

        const match = title.includes(query) || description.includes(query) || location.includes(query);

        card.style.display = match ? "block" : "none";
    });
}


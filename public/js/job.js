function openModal(title, details, location, method) {
    const modal = document.getElementById("job-modal");
    const modalText = document.getElementById("job-detail-text");

    modalText.innerHTML = `
        <strong>Title:</strong> ${title}<br>
        <strong>Location:</strong> ${location}<br>
        <strong>Details:</strong> ${details}<br>
        <strong>How to Apply:</strong> ${method}
    `;
    modal.style.display = "block";
}

function closeModal() {
    document.getElementById("job-modal").style.display = "none";
}
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
showToast("✅The job has been saved successfully.!");

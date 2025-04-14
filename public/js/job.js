function openModal(title, details, location, method) {
    const modal = document.getElementById("job-modal");
    const modalText = document.getElementById("job-detail-text");

    modalText.innerHTML = `
        <strong>Title:</strong> ${title}<br>
        <strong>Location:</strong> ${location}<br>
        <strong>Description:</strong> ${details}<br>
        <strong>How to Apply:</strong> ${method}
    `;
    modal.style.display = "block";
}

function closeModal() {
    document.getElementById("job-modal").style.display = "none";
}
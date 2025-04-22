function addTraining() {
    let name = document.getElementById("new-training").value;
    let certificate = document.getElementById("training-certificate").files[0];

    let formData = new FormData();
    formData.append("name", name);
    formData.append("certificate", certificate);

    fetch("/upload-training", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        document.getElementById("new-training").value = "";
        document.getElementById("training-certificate").value = "";
    })
    .catch(error => {
        console.error("Error uploading training:", error);
    });
}

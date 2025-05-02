
  document.getElementById('training-file').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('preview-image');
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 100%; height: auto; margin-top: 10px;" />`;
      };
      reader.readAsDataURL(file);
    } else {
      previewContainer.innerHTML = '<p>No preview available for this file type.</p>';
    }
  });


document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleCertificates');
    const hiddenCertificates = document.querySelectorAll('.hidden-certificate');

    toggleButton.addEventListener('click', function() {
        const isHidden = hiddenCertificates[0].style.display === 'none' || hiddenCertificates[0].style.display === '';

        if (isHidden) {
            // Show all
            hiddenCertificates.forEach(c => c.style.display = 'block');
            toggleButton.textContent = 'Show Less';
        } else {
            // Hide again
            hiddenCertificates.forEach(c => c.style.display = 'none');
            toggleButton.textContent = 'View All Certificates';
        }
    });
});


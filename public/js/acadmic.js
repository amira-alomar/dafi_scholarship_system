document.getElementById('training-file').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('training-preview-image');
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
  
  document.getElementById('volunteering-file').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('volunteering-preview-image');
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
  const trainingToggle = document.getElementById('toggleTrainingCertificates');
  const trainingCertificates = document.querySelectorAll('.training-certificate.hidden-certificate');

  trainingToggle?.addEventListener('click', function(e) {
    e.preventDefault();
    const isHidden = trainingCertificates[0]?.style.display === 'none' || trainingCertificates[0]?.style.display === '';
    trainingCertificates.forEach(card => card.style.display = isHidden ? 'block' : 'none');
    trainingToggle.textContent = isHidden ? 'Show Less' : 'View All Certificates';
  });

  const volunteeringToggle = document.getElementById('toggleVolunteeringCertificates');
  const volunteeringCertificates = document.querySelectorAll('.volunteering-certificate.hidden-certificate');

  volunteeringToggle?.addEventListener('click', function(e) {
    e.preventDefault();
    const isHidden = volunteeringCertificates[0]?.style.display === 'none' || volunteeringCertificates[0]?.style.display === '';
    volunteeringCertificates.forEach(card => card.style.display = isHidden ? 'block' : 'none');
    volunteeringToggle.textContent = isHidden ? 'Show Less' : 'View All Certificates';
  });
});




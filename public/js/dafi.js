
        // Filter opportunities by type
        function filterOpportunities(type) {
            // Update active tab
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('tab-active');
                tab.classList.add('text-gray-600', 'hover:text-gray-900');
            });
            event.target.classList.add('tab-active');
            event.target.classList.remove('text-gray-600', 'hover:text-gray-900');

            // Show/hide opportunities
            const opportunities = document.querySelectorAll('.opportunity');
            opportunities.forEach(opp => {
                if (type === 'all' || opp.classList.contains(type)) {
                    opp.style.display = 'block';
                } else {
                    opp.style.display = 'none';
                }
            });
        }

        // Open application modal
        function openApplicationModal(title, type) {
            const modal = document.getElementById('applicationModal');
            document.getElementById('modalTitle').textContent = type === 'volunteering' ? 'Apply for Opportunity' : 'Register for Opportunity';
            document.getElementById('opportunityName').value = title;
            document.getElementById('opportunityType').value = type;
            modal.style.display = 'block';
        }

        // Close modal
        function closeModal() {
            document.getElementById('applicationModal').style.display = 'none';
            document.getElementById('applicationForm').reset();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('applicationModal');
            if (event.target === modal) {
                closeModal();
            }
        }

setTimeout(function () {
    var message = document.getElementById('flash-message');
    if (message) {
        message.style.display = 'none';
    }
}, 5000); // الوقت بالملي ثانية (3000 = 3 ثواني)
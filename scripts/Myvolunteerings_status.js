document.addEventListener("DOMContentLoaded", function() {
    var completeButtons = document.querySelectorAll('.complete-button');
    var incompleteButtons = document.querySelectorAll('.incomplete-button');

    completeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var volunteeringId = this.getAttribute('data-volunteering-id');
            console.log("Complete button clicked. Volunteering ID:", volunteeringId);
            updateVolunteeringStatus(volunteeringId, 'Yes');
        });
    });

    incompleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var volunteeringId = this.getAttribute('data-volunteering-id');
            console.log("Incomplete button clicked. Volunteering ID:", volunteeringId);
            updateVolunteeringStatus(volunteeringId, 'No');
        });
    });

    async function updateVolunteeringStatus(volunteeringId, status) {
        try {
            const response = await fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'NumberOfVolunteering': volunteeringId,
                    'Status': status
                })
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const responseData = await response.text();
            console.log("Response from server:", responseData);
            
            // Display message based on server response
            if (responseData === 'Status changed.') {
                alert('Status changed.');
            } else if (responseData === 'Status didn\'t change.') {
                alert('Status didn\'t change.');
            } else {
                alert('Unexpected response from server.');
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }
});

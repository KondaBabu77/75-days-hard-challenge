document.addEventListener("DOMContentLoaded", function() {
    // Select update and reset buttons
    const updateBtn = document.querySelector(".update-btn");
    const resetBtn = document.querySelector(".reset-btn");

    // Update progress button alert
    if (updateBtn) {
        updateBtn.addEventListener("click", function() {
            alert("Your progress has been updated successfully!");
        });
    }

    // Reset progress confirmation
    if (resetBtn) {
        resetBtn.addEventListener("click", function(event) {
            if (!confirm("Are you sure? This will reset all progress to Day 1!")) {
                event.preventDefault(); // Stop form submission if user cancels
            }
        });
    }
});

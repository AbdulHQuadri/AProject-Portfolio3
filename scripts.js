function validateDates() {
  const startDateInput = document.querySelector('#sDate');
  const endDateInput = document.querySelector('#eDate');
  const startDate = new Date(startDateInput.value);
  const endDate = new Date(endDateInput.value);

  if (endDate < startDate) {
    alert('End date cannot be before start date');
    return false; // prevent form submission
  }
  return true; // allow form submission
}

const form = document.querySelector('#project-form');
form.addEventListener('submit', (event) => {
  if (!validateDates()) {
    event.preventDefault(); // prevent form submission
  }
});

function confirmDelete(projectId) {
  if (confirm("Are you sure you want to delete this project?")) {
    window.location.href = "deleteproject.php?id=" + projectId;
  }
}

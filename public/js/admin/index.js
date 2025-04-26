document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar collapse
    const collapseBtn = document.querySelector('.sidebar-collapse');
    const sidebar = document.querySelector('.admin-sidebar');

    if (collapseBtn && sidebar) {
        collapseBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
});


const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

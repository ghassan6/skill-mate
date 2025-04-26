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

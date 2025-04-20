document.addEventListener('DOMContentLoaded', function() {
    // Animate radio selection
    const conflictRows = document.querySelectorAll('.conflict-row');
    conflictRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.conflict-radio')) {
                const radio = this.querySelector('.conflict-radio');
                if (radio) {
                    radio.checked = true;
                    this.classList.add('bg-primary-light');
                    conflictRows.forEach(r => {
                        if (r !== this) r.classList.remove('bg-primary-light');
                    });
                }
            }
        });
    });

    // Real-time time indicator updates
    function updateTimeIndicators() {
        document.querySelectorAll('.time-indicator').forEach(el => {
            const time = new Date(el.dataset.time);
            const now = new Date();
            const diff = Math.floor((now - time) / 1000);

            let text;
            if (diff < 60) text = 'Just now';
            else if (diff < 3600) text = `${Math.floor(diff/60)} min ago`;
            else if (diff < 86400) text = `${Math.floor(diff/3600)} hr ago`;
            else text = `${Math.floor(diff/86400)} days ago`;

            el.querySelector('.time-text').textContent = text;
        });
    }

    updateTimeIndicators();
    setInterval(updateTimeIndicators, 60000);

    // Tooltip initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Read more functionality
    document.querySelectorAll('.read-more').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const fullText = this.parentElement.getAttribute('title');
            this.parentElement.innerHTML = fullText;
        });
    });
});

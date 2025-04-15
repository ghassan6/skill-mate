document.addEventListener('DOMContentLoaded', function() {
    const bioTextarea = document.getElementById('bio');
    const charLimit = 500;

    if (bioTextarea) {
        // Create counter element
        const counter = document.createElement('div');
        counter.className = 'text-muted small text-end mt-1';
        bioTextarea.parentNode.appendChild(counter);

        // Update counter on input
        bioTextarea.addEventListener('input', function() {
            const remaining = charLimit - this.value.length;
            counter.textContent = `${remaining} characters remaining`;

            if (remaining < 0) {
                counter.classList.add('text-danger');
                this.classList.add('is-invalid');
            } else {
                counter.classList.remove('text-danger');
                this.classList.remove('is-invalid');
            }
        });

        // Initial update
        bioTextarea.dispatchEvent(new Event('input'));
    }
});

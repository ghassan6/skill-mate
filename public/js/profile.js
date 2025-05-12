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

function selectLimitPackage(slots, amount) {
    document.getElementById('additionalSlots').value = slots;
    document.getElementById('limitIncreaseAmount').value = amount;
    document.getElementById('proceedToLimitPayment').disabled = false;

    // Highlight selected card
    document.querySelectorAll('#increaseLimitModal .pricing-card').forEach(card => {
        card.classList.remove('bg-primary', 'bg-opacity-10');
        card.classList.add('border-primary');
    });
    event.target.closest('.pricing-card').classList.add('bg-primary', 'bg-opacity-10');
    event.target.closest('.pricing-card').classList.remove('border-primary');
}

// Reset form when modal is closed
document.getElementById('increaseLimitModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('limitIncreaseForm').reset();
    document.getElementById('proceedToLimitPayment').disabled = true;
    document.querySelectorAll('#increaseLimitModal .pricing-card').forEach(card => {
        card.classList.remove('bg-primary', 'bg-opacity-10');
        card.classList.add('border-primary');
    });
});

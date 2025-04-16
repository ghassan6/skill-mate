document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('#serviceGallery');
    const counter = document.querySelector('#carousel-counter');
    const totalItems = carousel.querySelectorAll('.carousel-item').length;

    // Function to update the current image index
    function updateCounter() {
        const activeItem = carousel.querySelector('.carousel-item.active');
        const items = Array.from(carousel.querySelectorAll('.carousel-item'));
        const currentIndex = items.indexOf(activeItem) + 1;  // add 1 to make it 1-based index
        counter.textContent = `${currentIndex} / ${totalItems}`;
    }

    // Update counter on page load
    updateCounter();

    // Listen for when the carousel slides
    carousel.addEventListener('slid.bs.carousel', function () {
        updateCounter();  // Update the counter on slide
    });

    // add to favorites , save the service
    document.querySelectorAll('.save-service-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault(); // Prevent default form submission
            const form = this.closest('form');
            const icon = this.querySelector('i');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                if (response.status === 401) {
                    window.location.href = '/login';
                    return;
                }

                const data = await response.json();

                if (data.is_saved) {
                    icon.classList.remove('fa-heart-o');
                    icon.classList.add('fa-heart');
                    this.style.color = '#dc3545';
                    this.title = 'Remove from saved services';
                    this.setAttribute('data-saved', '1');
                } else {
                    icon.classList.remove('fa-heart');
                    icon.classList.add('fa-heart');
                    this.style.color = '#6c757d';
                    this.title = 'Save this service';
                    this.setAttribute('data-saved', '0');
                }

                if (typeof showToast === 'function') {
                    showToast(data.message);
                } else {
                    console.log(data.message);
                }

            } catch (error) {
                console.error('Error:', error);
                if (typeof showToast === 'function') {
                    showToast('An error occurred', 'error');
                }
            }
        });
    });


    // for contact modal

    // Contact Button Logic (for triggering the modal)
    const contactBtn = document.querySelector('.contact-btn');
    if (contactBtn) {
        contactBtn.addEventListener('click', function(e) {
            const isAuthenticated = this.dataset.authenticated === 'true';
            if (!isAuthenticated) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            e.preventDefault();
            let inquiryModal = new bootstrap.Modal(document.getElementById('inquiryModal'));
            inquiryModal.show();
        });
    }

    // Quick message buttons
    document.querySelectorAll('.quick-message').forEach(button => {
        button.addEventListener('click', function() {
            const template = this.getAttribute('data-template');
            const textarea = document.getElementById('message');
            textarea.value = template;
            textarea.focus();
        });
    });

    // Initialize flatpickr on the datetime input (combining date and time)
    flatpickr(".flatpickr-datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 30,
        minDate: "today",
        disable: [
            function(date) {
                // Disable weekends (Saturday=6, Sunday=0)
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ]
    });

    // Form submission handling
    document.getElementById('inquiryForm').addEventListener('submit', function(e) {
        if (!document.getElementById('agreeTerms').checked) {
            e.preventDefault();
            alert('Please agree to the terms before submitting');
        }
        // Optionally add AJAX submission logic here
    });
});

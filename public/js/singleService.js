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

    // In your singleService.js
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

});

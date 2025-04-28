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
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.color = '#dc3545'; // red
                    this.title = 'Remove from saved services';
                    this.setAttribute('data-saved', '1');
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "The service has been saved",
                        showConfirmButton: false,
                        timer: 1500
                      });
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.color = '#6c757d'; // gray
                    this.title = 'Save this service';
                    this.setAttribute('data-saved', '0');
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "The service has been Unsaved",
                        showConfirmButton: false,
                        timer: 1500
                      });
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
    let contactBtn = document.querySelector('.contact-btn');
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
    });

    // Form submission handling
    document.getElementById('inquiryForm').addEventListener('submit', function(e) {
        if (!document.getElementById('agreeTerms').checked) {
            e.preventDefault();
            alert('Please agree to the terms before submitting');
        }

    });


    // for review (reviewing) the service

    let stars = document.querySelectorAll('.star-rating .star');
    let ratingInput = document.getElementById('ratingInput');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                let rating = star.getAttribute('data-value');
                ratingInput.value = rating;

                stars.forEach(s => {
                    s.classList.toggle('filled', s.getAttribute('data-value') <= rating);
                });
            });
        });

        // review form validation
        let form = document.getElementById('reviewForm');

        form.addEventListener('submit', function (e) {
            if (!validateReview()) {
                e.preventDefault(); // stops form submission if validation fails
            }
        });

        function validateReview(e) {
            let rating = parseInt(document.getElementById('ratingInput').value);
            let comment = document.getElementById('comment').value.trim();

            let ratingError = document.getElementById('ratingError');
            let commentError = document.getElementById('commentError');

            // Clear previous errors
            ratingError.textContent = '';
            commentError.textContent = '';

            let isValid = true;

            if (isNaN(rating) || rating < 1 || rating > 5) {
                ratingError.textContent = 'Please select a rating between 1 and 5.';
                isValid = false;
            }

            if (comment.length < 5 || comment.length > 200) {
                commentError.textContent = 'Please write at least 5 characters and no longer than 200 characters ';
                isValid = false;
            }

            return isValid;
        }

        document.querySelectorAll('.edit-review-btn').forEach(btn => {
            btn.addEventListener('click', () => {
              // parse the JSON safely at runtime
              const review = JSON.parse(btn.dataset.review);
              openReviewModal(review);
            });
          });

        function openReviewModal(review = null) {
            const form         = document.getElementById('reviewForm');
            const defaultUrl   = form.dataset.defaultAction;
            const methodInput  = document.getElementById('methodField');
            const commentInput = document.getElementById('comment');
            const ratingInput  = document.getElementById('ratingInput');
            const reviewInput  = document.getElementById('reviewId');

            if (review) {
              // Edit mode
              form.action = `/reviews/${review.id}`;
              methodInput.value = 'PUT';
              commentInput.value = review.comment;
              ratingInput.value = review.rating;
              reviewInput.value = review.id;
            //   highlightStars(review.rating);
            } else {
              // Add mode
              form.action = defaultUrl;
              methodInput.value = 'POST';
              commentInput.value = '';
              ratingInput.value = 0;
              reviewInput.value = '';
            //   highlightStars(0);
            }

            new bootstrap.Modal(document.getElementById('reviewModal')).show();
          }

});





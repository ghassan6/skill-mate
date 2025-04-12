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
});

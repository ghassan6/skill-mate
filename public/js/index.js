document.addEventListener('DOMContentLoaded', function() {
    const carousel = new bootstrap.Carousel(document.getElementById('featuredCarousel'), {
        interval: false
    });

    document.querySelector('.featured-prev').addEventListener('click', function() {
        carousel.prev();
    });

    document.querySelector('.featured-next').addEventListener('click', function() {
        carousel.next();
    });
});

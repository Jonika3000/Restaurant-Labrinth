document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('[data-carousel="slide"]');
    const slides = carousel.querySelectorAll('[data-carousel-item]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const indicators = carousel.querySelectorAll('[data-carousel-slide-to]');
    let currentIndex = 0;

    const goToSlide = (index) => {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
        });
        currentIndex = index;
    };

    const nextSlide = () => {
        let nextIndex = (currentIndex + 1) % slides.length;
        goToSlide(nextIndex);
    };

    const prevSlide = () => {
        let prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(prevIndex);
    };

    nextButton.addEventListener('click', () => {
        nextSlide();
    });

    prevButton.addEventListener('click', () => {
        prevSlide();
    });

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
        });
    });

    goToSlide(currentIndex);
});
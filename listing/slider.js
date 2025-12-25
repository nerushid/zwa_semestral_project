document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.single-listing-slider');
    
    if (!slider) return;

    const wrapper = slider.querySelector('.slider-wrapper');
    const slides = slider.querySelectorAll('.slide-image');
    const prevBtn = slider.querySelector('.prev-btn');
    const nextBtn = slider.querySelector('.next-btn');
    const counter = slider.querySelector('.slide-counter'); 

    if (!prevBtn || !nextBtn) return;

    let currentIndex = 0;
    const totalSlides = slides.length;

    function updateSlider() {
        wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        if (counter) {
            counter.textContent = `${currentIndex + 1} / ${totalSlides}`;
        }
    }

    nextBtn.addEventListener('click', () => {
        currentIndex++;
        if (currentIndex >= totalSlides) {
            currentIndex = 0; 
        }
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = totalSlides - 1;
        }
        updateSlider();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const listings = document.querySelectorAll('.listing-item');
    
    listings.forEach(listing => {
        const listingId = listing.dataset.listingId;
        const images = listing.querySelectorAll('.slider-image');
        const dots = listing.querySelectorAll('.dot');
        const prevBtn = listing.querySelector('.prev-btn');
        const nextBtn = listing.querySelector('.next-btn');
        
        if (images.length <= 1) return;
        
        let currentIndex = 0;
        
        function showImage(index) {
            images.forEach(img => img.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            images[index].classList.add('active');
            dots[index].classList.add('active');
            currentIndex = index;
        }
        
        function nextImage(e) {
            e.preventDefault();
            e.stopPropagation();
            const newIndex = (currentIndex + 1) % images.length;
            showImage(newIndex);
        }
        
        function prevImage(e) {
            e.preventDefault();
            e.stopPropagation();
            const newIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(newIndex);
        }
        
        if (nextBtn) nextBtn.addEventListener('click', nextImage);
        if (prevBtn) prevBtn.addEventListener('click', prevImage);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                showImage(index);
            });
        });
    });
});

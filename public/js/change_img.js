document.addEventListener('DOMContentLoaded', function() {
    const mainImageContainer = document.querySelector('.main-image-container');
    const mainImage = document.querySelector('.main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let currentIndex = 0;
    
    // Extract all image paths from thumbnails
    const imagePaths = Array.from(thumbnails).map(thumb => thumb.src);
    
    // Initialize gallery
    updateMainImage(currentIndex);
    
    // Thumbnail click event
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            currentIndex = index;
            updateMainImage(currentIndex);
            updateActiveThumbnail(currentIndex);
        });
    });
    
    // Previous button
    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
        updateMainImage(currentIndex);
        updateActiveThumbnail(currentIndex);
    });
    
    // Next button
    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % thumbnails.length;
        updateMainImage(currentIndex);
        updateActiveThumbnail(currentIndex);
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            updateMainImage(currentIndex);
            updateActiveThumbnail(currentIndex);
        } else if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateMainImage(currentIndex);
            updateActiveThumbnail(currentIndex);
        }
    });
    
    function updateMainImage(index) {
        // Update main image source
        mainImage.src = imagePaths[index];
        mainImage.alt = thumbnails[index].alt;
    }
    
    function updateActiveThumbnail(index) {
        // Update thumbnails
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        thumbnails[index].classList.add('active');
    }
});
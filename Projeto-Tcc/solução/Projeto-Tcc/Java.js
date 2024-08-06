const carouselItems = document.querySelectorAll('.carousel-item');
const carouselControls = document.querySelectorAll('.carousel-control');

let currentSlide = 0;

carouselControls.forEach((control, index) => {
  control.addEventListener('click', () => {
    if (index === 0) {
      currentSlide = (currentSlide - 1 + carouselItems.length) % carouselItems.length;
    } else {
      currentSlide = (currentSlide + 1) % carouselItems.length;
    }
    updateCarousel();
  });
});

function updateCarousel() {
  carouselItems.forEach((item, index) => {
    item.style.opacity = index === currentSlide? 1 : 0;
  });
}

updateCarousel();
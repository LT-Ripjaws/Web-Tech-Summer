// This script  handles slideahow
let slideIndex = 0;
const slides = document.querySelector(".slides");
const slideImages = document.querySelectorAll(".slides img");
const totalSlides = slideImages.length;

document.querySelector(".next").addEventListener("click", () => {
    slideIndex = (slideIndex + 1) % totalSlides;
    updateSlide();
});

document.querySelector(".prev").addEventListener("click", () => {
    slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
    updateSlide();
});

function updateSlide() {
    slides.style.transform = `translateX(-${slideIndex * 100}%)`;
}


setInterval(() => {
    slideIndex = (slideIndex + 1) % totalSlides;
    updateSlide();
}, 30000);



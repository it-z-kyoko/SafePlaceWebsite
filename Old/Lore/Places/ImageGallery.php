<?php
$dir = '../../images/Places/' . $id; // Verzeichnispfad zu den Bildern
$images = glob($dir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE); // Akzeptiert jpg, jpeg, png, gif

if (empty($images)) {
    echo "Keine Bilder gefunden.";
} else {
    echo '<div class="slideshow-container">';
    foreach ($images as $image) {
        echo '<div class="mySlides fade">';
        echo '<img src="' . $image . '" alt="Bild">';
        echo '</div>';
    }
    echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>';
    echo '<a class="next" onclick="plusSlides(1)">&#10095;</a>';
    echo '</div>';

    echo '<div class="dots">';
    for ($i = 0; $i < count($images); $i++) {
        echo '<span class="dot" onclick="currentSlide(' . ($i + 1) . ')"></span>';
    }
    echo '</div>';
}
?>


<script>
    let slideIndex = 1;
let autoPlayInterval;

showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    const slides = document.querySelectorAll('.mySlides');
    const dots = document.querySelectorAll('.dot');

    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }

    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(' active', '');
    }

    slides[slideIndex - 1].style.display = 'block';
    dots[slideIndex - 1].className += ' active';
}

function autoPlay() {
    plusSlides(1);
}

function startAutoPlay() {
    autoPlayInterval = setInterval(autoPlay, 5000); // Ändere den Wert, um die Wiedergabegeschwindigkeit anzupassen
}

function stopAutoPlay() {
    clearInterval(autoPlayInterval);
}

startAutoPlay();

</script>

<style>
/* Slideshow-Container */
.slideshow-container {
    height: fit-content;
    position: relative;
    margin: 0 auto;
    text-align: center; /* Textzentrierung für die Inhalte */
}

/* Einzeln Slideshow-Folien */
.mySlides {
    display: none;
}

/* Navigationspfeile (prev und next) */
.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%); /* Vertikale Ausrichtung in der Mitte */
    width: auto;
    padding: 16px;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    user-select: none;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

/* Punkte (dots) unter der Slideshow */
.dots {
    text-align: center;
    margin: 0 auto;
    margin-top: 20px;
}

.dot {
    height: 15px;
    width: 15px;
    margin: 0 auto;
    background-color: #bbb; /* Hintergrundfarbe für inaktive Punkte */
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
    cursor: pointer;
}

.active {
    background-color: #717171; /* Hintergrundfarbe für den aktiven Punkt */
}

img {
    max-height: 500px;
    max-width: 50%;
    margin: 0 auto;
    object-fit: contain;
}

</style>

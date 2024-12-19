// Afficher par défaut la section "index.php"
showSection('home');

// Initialisation du carrousel
let currentIndex = 0;
const images = document.querySelectorAll('.carousel-item'); // Récupère toutes les images du carrousel

// Fonction pour afficher une image spécifique du carrousel
function showImage(index) {
    images.forEach((img, i) => img.classList.toggle('active', i === index)); // Affiche l'image active
}


// Fonction pour aller à l'image suivante
function nextImage() {
    currentIndex = (currentIndex + 1) % images.length; // Incrémente l'index, et revient à 0 quand on arrive à la fin
    showImage(currentIndex); // Affiche l'image correspondante
}

// Fonction pour aller à l'image précédente
function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length; // Décrémente l'index, et revient à la dernière image si l'on est au début
    showImage(currentIndex); // Affiche l'image correspondante
}

// Intervalles de changement d'image toutes les 3 secondes
setInterval(nextImage, 3000);

// Ajout des événements pour les boutons de navigation du carrousel
document.querySelector('.carousel-control.next').addEventListener('click', nextImage);
document.querySelector('.carousel-control.prev').addEventListener('click', prevImage);
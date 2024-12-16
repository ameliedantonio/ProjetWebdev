// Fonction pour afficher une section spécifique
function showSection(sectionId) {
    const pages = document.querySelectorAll('.page');
    pages.forEach(page => page.classList.remove('active')); // Cache toutes les pages
    document.getElementById(sectionId).classList.add('active'); // Affiche la section demandée
}

// Ajout d'événements de clic sur les liens de navigation
document.querySelectorAll('nav a').forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault(); // Empêche le comportement par défaut (scroll vers l'ancre)
        const sectionId = link.getAttribute('href').substring(1); // Récupère l'ID de la section
        showSection(sectionId); // Affiche la section correspondante
    });
});

// Afficher par défaut la section "home"
showSection('home');

// Initialisation du carrousel
let currentIndex = 0;
const images = document.querySelectorAll('.carousel-item'); // Récupère toutes les images du carrousel

// Fonction pour afficher une image spécifique du carrousel
function showImage(index) {
    images.forEach((img, i) => img.classList.toggle('active', i === index)); // Affiche l'image active
}

//Fonction pour gerer l'ouverture et fermeture des panneaux d'enclos
function toggleEnclosures(biomeId) {
    const enclosure = document.getElementById(biomeId);
    if (enclosure.style.display === "block") {
        enclosure.style.display = "none";
    } else {
        enclosure.style.display = "block";
    }
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


document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split("/").pop();
    const menuLinks = document.querySelectorAll("nav a");
  
    menuLinks.forEach(link => {
      if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  });
  
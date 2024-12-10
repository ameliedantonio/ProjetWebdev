document.addEventListener("DOMContentLoaded", () => {
  // Gestion du carrousel
  const carouselImages = document.querySelectorAll(".carousel img");
  let currentIndex = 0;

  function showNextImage() {
    carouselImages[currentIndex].classList.remove("active");
    currentIndex = (currentIndex + 1) % carouselImages.length;
    carouselImages[currentIndex].classList.add("active");
  }

  setInterval(showNextImage, 3000);

  // Gestion des biomes
  const biomes = document.querySelectorAll(".biome");
  biomes.forEach(biome => {
    biome.addEventListener("click", () => {
      const enclosures = biome.querySelectorAll(".enclosure");
      enclosures.forEach(enclosure => {
        enclosure.classList.toggle("expanded");
      });
    });
  });

  // Gestion des enclos
  const enclosures = document.querySelectorAll(".enclosure");
  enclosures.forEach(enclosure => {
    enclosure.addEventListener("click", e => {
      e.stopPropagation();
      const animals = enclosure.querySelector(".animals");
      animals.classList.toggle("visible");
    });
  });
});

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


document.addEventListener("DOMContentLoaded", () => {
    const biomes = document.querySelectorAll('.biome');
  
    // Ajouter un événement au clic pour chaque biome
    biomes.forEach(biome => {
      biome.addEventListener('click', () => {
        const enclosures = biome.querySelectorAll('.enclosure');
        enclosures.forEach(enclosure => {
          // Toggle (affichage/masquage) des enclos lorsque le biome est cliqué
          enclosure.classList.toggle('expanded');
        });
      });
    });
  
    // Optionnel : Gérer l'ouverture et la fermeture des animaux dans les enclos
    const enclosures = document.querySelectorAll('.enclosure');
    enclosures.forEach(enclosure => {
      enclosure.addEventListener('click', (e) => {
        // Empêche la propagation de l'événement pour ne pas déclencher l'événement du biome
        e.stopPropagation();
  
        const animals = enclosure.querySelector('.animals');
        animals.classList.toggle('visible');
      });
    });
  });
  
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php require_once "Template.php"; ?>
<?php ob_start(); ?>

<div class="full-width-image">
    <img src="asset/food4.jpeg" alt="Sunugal">
    <div class="search-overlay">
        <input type="text" id="search" placeholder="Rechercher une recette, ingrédient ou tag...">
    </div>
</div>

<div id="recettes" class="recettes-container"></div>

<script>
function afficherRecettes(data, fromSearch = false) {
  const container = document.querySelector('#recettes');
  container.innerHTML = '';
  const desserts = ['Thiakiri', 'Beignet Coco', 'Jus Bissap', 'Jus Bouye', 'Pastel'];
  
  data.forEach(recipe => {
    const nom = recipe.title ?? recipe.name;
    let imgPath;
    
    if (fromSearch) {
      const dossier = desserts.includes(nom) ? 'image_dessert' : 'image_plat';
      imgPath = `/projet_web123/frontend/asset/images_recettes/${dossier}/${recipe.photo}`;
    } else {
      imgPath = `/projet_web123/frontend/${recipe.photo}`;
    }

    const div = document.createElement('div');
    div.classList.add('card');
    div.innerHTML = `
      <h2>${nom}</h2>
      <img src="${imgPath}">
      <p>${recipe.description.substring(0, 80)}...</p>
      <a href="recipeDetail.php?id=${recipe.id}">Voir la recette</a>
    `;
    container.appendChild(div);
  });
}

// Chargement initial
fetch('/projet_web123/frontend/recipe_api.php')
  .then(res => res.json())
  .then(data => afficherRecettes(data, false));

// Recherche
document.querySelector('#search').addEventListener('input', function() {
  const query = this.value.trim();
  if (query === '') {
    fetch('/projet_web123/frontend/recipe_api.php')
      .then(res => res.json())
      .then(data => afficherRecettes(data, false));
  } else {
    fetch(`/projet_web123/frontend/searchBar.php?title=${query}&ingredient=${query}&tag=${query}`)
      .then(res => res.json())
      .then(data => afficherRecettes(data, true));
  }
});
</script>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
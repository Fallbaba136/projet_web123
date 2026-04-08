<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php require_once "Template.php"; ?>
<?php ob_start(); ?>

<div id="recipe-detail"></div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

fetch(`/projet_web123/frontend/displayRecipe.php?id=${id}`)
  .then(res => res.json())
  .then(data => {
    const recipe = data.recipe;
    const ingredients = data.ingredients;
    const tags = data.tags;

    const desserts = ['Thiakiri', 'Beignet Coco', 'Jus Bissap', 'Jus Bouye', 'Pastel'];
    const dossier = desserts.includes(recipe.title) ? 'image_dessert' : 'image_plat';
    const imgPath = `/projet_web123/frontend/asset/images_recettes/${dossier}/${recipe.photo}`;

    const ingredientsHTML = ingredients.map(i => `
      <div class="ingredient">
        <img src="/projet_web123/frontend/asset/images_recettes/image_ingredient/${i.image}" alt="${i.name}">
        <p>${i.name}</p>
      </div>
    `).join('');

    const tagsHTML = tags.map(t => `<span class="tag">${t.name}</span>`).join('');

    document.querySelector('#recipe-detail').innerHTML = `
      <div class="recipe-hero">
        <img src="${imgPath}" alt="${recipe.title}">
      </div>
      <div class="recipe-body">
        <h1>${recipe.title}</h1>
        <p>${recipe.description}</p>
        <div class="tags">${tagsHTML}</div>
        <h2>Ingrédients</h2>
        <div class="ingredients-grid">${ingredientsHTML}</div>
      </div>
    `;
  });
</script>

<?php $content = ob_get_clean(); ?>
<?php Template::render($content); ?>
fetch('/projet_web123/frontend/recipe_api.php')
  .then(res => res.json())
  .then(data => {
    const container = document.querySelector('#recettes');
    container.innerHTML = '';

    data.forEach(recipe => {
      const div = document.createElement('div');
      div.classList.add('card');
      div.innerHTML = `
        <h2>${recipe.name}</h2>
        <img src="/projet_web123/frontend/${recipe.photo}">
        <p>${recipe.description.substring(0, 80)}...</p>
        <a href="recipe.php?id=${recipe.id}">Voir la recette</a>
      `;
      container.appendChild(div);
    });
  });
  /**
   * Explication du code :
   * 1. On utilise la fonction fetch pour envoyer une requête GET à l'API située à 'recipe_api.php'.
   * 2. Lorsque la réponse est reçue, on la convertit en JSON avec res.json().
   * 3. Ensuite, on traite les données reçues, qui sont supposées être un tableau de recettes.
   * 4. On sélectionne le conteneur HTML où les recettes seront affichées et on le vide pour éviter d'afficher des données obsolètes.
   * 5. Pour chaque recette dans les données, on crée une nouvelle div avec la classe 'card' et on remplit son contenu avec le nom de la recette, une image, une description tronquée et un lien vers la page de détails de la recette.
   * 6. Enfin, on ajoute cette div au conteneur pour l'afficher sur la page.
   * Note : Assurez-vous que les chemins vers les images et les liens sont corrects et que l'API renvoie les données dans le format attendu.
   *  --- IGNORE ---    
   */
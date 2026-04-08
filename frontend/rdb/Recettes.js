
function addIngredient() {
    let container = document.getElementById("ingredients-container");
    let div = document.createElement("div");
    div.classList.add("ingredient-item");
    div.innerHTML = `<input list="ingredients-list" name="ingredients[]" placeholder="Choisir ingrédient">
                     <button type="button" onclick="removeIngredient(this)">❌</button>`;
    container.appendChild(div);
}

function removeIngredient(btn){
    btn.parentElement.remove();
}


function openModal(){
    document.getElementById("modal").style.display = "block";
}

function closeModal(){
    document.getElementById("modal").style.display = "none";
}

function saveIngredient(){
    let name = document.getElementById("newIngredientName").value;
    let image = document.getElementById("newIngredientImage").files[0];

    let formData = new FormData();
    formData.append("name", name);
    formData.append("image", image);

    fetch("/projet_web123/backend/admin/ajax_create_ingredient.php", {
        method: "POST",
        body: formData
    })
  .then(res => res.json()) 
    .then(data =>{

       console.log(data);
      
        if(data.success){

            let datalist = document.getElementById("ingredients-list");
            let option = document.createElement("option");
            option.value = data.name;
            datalist.appendChild(option);

            closeModal(); 
        }
        else{
            console.log(" yo le data n'a pas eu de success")
        }
    })
    .catch(err => console.error(err));
}


function addTag() {
    let container = document.getElementById("tags-container");

    let div = document.createElement("div");
    div.classList.add("tag-item");

    div.innerHTML = `
        <input list="tags-list" name="tags[]" placeholder="Choisir tag">
        <button type="button" onclick="removeTag(this)">❌</button>
    `;

    container.appendChild(div);
}

function openTagModal(){
    document.getElementById("tagModal").style.display = "block";
}

function closeTagModal(){
    document.getElementById("tagModal").style.display = "none";
}

function saveTag(){

    let name = document.getElementById("newTagName").value;

    let formData = new FormData();
    formData.append("name", name);

    fetch("/projet_web123/backend/admin/ajax_create_tag.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if(data.success){

            let datalist = document.getElementById("tags-list");

            let option = document.createElement("option");
            option.value = data.name;

            datalist.appendChild(option);

            closeTagModal();
        }
    })
    .catch(err => {
        console.log(err);
    });
}


function removeTag(btn){
    btn.parentElement.remove();
}

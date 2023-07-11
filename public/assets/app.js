// L'image img#image
let imageContainer = document.getElementById("image-container");

// La fonction previewPictures
let previewPictures = function (e) {
    // Réinitialiser l'URL de l'image
    imageContainer.innerHTML = "";

    // e.files contient un objet FileList
    const pictures = Array.from(e.files);
    console.log(pictures);

    // Boucle sur chaque image
    pictures.forEach(function (picture) {
        // Créer un nouvel élément d'image
        let img = document.createElement("img");
        img.style.maxWidth = "100px";
        img.style.marginRight = "10px";

        // Définir l'URL de l'image
        img.src = URL.createObjectURL(picture);

        // Ajouter l'image à la page
        imageContainer.appendChild(img);
    });
}

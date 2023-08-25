console.log('hello');
window.onload = () => {
    const modale = document.querySelector('.ca-modal-box');
    const close = document.querySelector('.ca-close');
    const links = document.querySelectorAll('.ca-gallery');
    console.log(links);
    for (let link of links) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const img = modale.querySelector('.ca-modal-content img');
            img.src = this.href;
            modale.classList.add("ca-show-modal");

        })
    }
    close.addEventListener('click', function () {

        modale.classList.remove("ca-show-modal");
    });
    modale.addEventListener('click', function () {
        modale.classList.remove("ca-show-modal");
    });
}


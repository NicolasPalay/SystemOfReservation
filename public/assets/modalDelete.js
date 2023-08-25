window.onload = () => {
    const modaleDeletes = document.querySelectorAll('.ca-href-delete');
    const closeButtons = document.querySelectorAll('.ca-close');

    for (let modaleDelete of modaleDeletes) {
        modaleDelete.addEventListener('click', function (e) {
            e.preventDefault();
            const bookId = this.dataset.bookId;
            const deleteLink = document.querySelector('.delete-book-link');
            deleteLink.setAttribute('href', "{{ path('admin_book_delete', {id: 0}) }}".replace(/\/\d+$/, '/' + bookId));
            const modale = this.closest('.ca-box-book').querySelector('.modaleDelete');
            modale.classList.add("ca-delete-display-modal");
        });
    }

    for (let closeButton of closeButtons) {
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            const modale = this.closest('.modaleDelete');
            modale.classList.remove("ca-delete-display-modal");
        });
    }
}

const deleteForm = document.querySelectorAll(".delete-form");
const modalBody = document.querySelector(".modal-body");
const modalTitle = document.querySelector(".modal-title");
const deleteButton = document.getElementById("deleteButton");

deleteForm.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const name = form.dataset.title;

        //Se il form contiene la classe delete-all allora fai uscire questo messaggio:
        if (form.classList.contains("delete-all")) {
            modalBody.innerText = "Vuoi svuotare il cestino?";
            modalTitle.innerText = "Svuota cestino";

            //Altrimenti fai uscire quest'altro:
        } else {
            modalBody.innerText = `Sei sicuro di voler eliminare "${name}"`;
            modalTitle.innerText = "Eliminazione appartamento";
        }

        deleteButton.addEventListener("click", function () {
            form.submit();
        });
    });
});

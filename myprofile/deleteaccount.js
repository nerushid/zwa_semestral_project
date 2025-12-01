const deleteAccountButton = document.getElementById("deleteaccountBtn");

if (deleteAccountButton) {
    deleteAccountButton.addEventListener("click", popWindow);
}

function popWindow(event) {
    event.preventDefault();
    const dialog = document.getElementById("deleteaccount-dialog");
    if (typeof dialog.showModal === "function") {
        dialog.showModal();
    } else {
        alert("The <dialog> API is not supported by this browser");
    }

    const cancelButton = dialog.querySelector("button#cancel");
    cancelButton.addEventListener("click", () => {
        dialog.close();
    });

    dialog.addEventListener('click', (e) => {
        if (e.target === dialog) {
            dialog.close();
        }
    });
}
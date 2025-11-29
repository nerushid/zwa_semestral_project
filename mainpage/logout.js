const logoutButton = document.getElementById("logout");

if (logoutButton) {
    logoutButton.addEventListener("click", popWindow);
}

function popWindow(event) {
    const dialog = document.getElementById("logout-dialog");
    if (typeof dialog.showModal === "function") {
        dialog.showModal();
    } else {
        alert("The <dialog> API is not supported by this browser");
    }

    const cancelButton = dialog.querySelector("button");
    cancelButton.addEventListener("click", () => {
        dialog.close();
    });

    dialog.addEventListener('click', (e) => {
        if (e.target === dialog) {
            dialog.close();
        }
    });
}
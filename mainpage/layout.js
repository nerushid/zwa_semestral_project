const toggle = document.getElementById("layout-toggleid")
const chekboxes = document.getElementById("layout-checkboxes")
let isOpen = false;

toggle.addEventListener("change", function(e) {
    if (!isOpen) {
        chekboxes.style.display = "block"
    } else {
        chekboxes.style.display = "none"
    }
    isOpen = !isOpen
})
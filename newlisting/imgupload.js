const fileUpload = document.getElementById("file-upload")
const previewContainer = document.getElementById("preview-container")

fileUpload.addEventListener("change", function(e) {
    previewContainer.innerHTML = ""
    const files = e.target.files

    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader()
        reader.onload = function(loadE) {
            const newElement = document.createElement("img")
            const file = loadE.target.result
            newElement.src = file

            newElement.style.width = '150px';
            newElement.style.height = '150px';
            newElement.style.objectFit = 'cover';
            newElement.style.margin = '5px';
            previewContainer.appendChild(newElement)
        }

        reader.readAsDataURL(files[i])
    }
})
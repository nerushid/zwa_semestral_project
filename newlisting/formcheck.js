const listingForm = document.getElementById("formid");

if (listingForm) {
    listingForm.addEventListener("submit", validateListingForm);
}

function validateListingForm(event) {

    const pragueSelectValue = document.getElementById('praha-selectid').value;
    const districtSelectValue = document.getElementById('districtid').value;
    const layoutSelectValue = document.getElementById('layoutid').value;
    const areaValue = document.getElementById('areaid').value.trim();
    const priceValue = document.getElementById('priceid').value.trim();
    const descriptionValue = document.getElementById('descriptionid').value.trim();
    const fileInput = document.getElementById('file-upload');

    let isFormValid = true;

    if (pragueSelectValue === "") {
        isFormValid = false;
        document.getElementById('praha-select-errorid').innerHTML = "* Please select a Praha region.";
    } else {
        document.getElementById('praha-select-errorid').innerHTML = "";
    }

    if (districtSelectValue === "") {
        isFormValid = false;
        document.getElementById('district-errorid').innerHTML = "* Please select a district.";
    } else {
        document.getElementById('district-errorid').innerHTML = "";
    }

    if (layoutSelectValue === "") {
        isFormValid = false;
        document.getElementById('layout-errorid').innerHTML = "* Please select a layout.";
    } else {
        document.getElementById('layout-errorid').innerHTML = "";
    }

    if (areaValue === "") {
        isFormValid = false;
        document.getElementById('area-errorid').innerHTML = "* Area cannot be blank.";
    } else if (!/^[1-9]\d*$/.test(areaValue)) {
        isFormValid = false;
        document.getElementById('area-errorid').innerHTML = "* Please enter a valid positive number (e.g., 50).";
    } else {
        document.getElementById('area-errorid').innerHTML = "";
    }

    if (priceValue === "") {
        isFormValid = false;
        document.getElementById('price-errorid').innerHTML = "* Price cannot be blank.";
    } else if (!/^[1-9]\d*$/.test(priceValue)) {
        isFormValid = false;
        document.getElementById('price-errorid').innerHTML = "* Please enter a valid positive number (e.g., 15000).";
    } else {
        document.getElementById('price-errorid').innerHTML = "";
    }

    if (descriptionValue === "") {
        isFormValid = false;
        document.getElementById('description-errorid').innerHTML = "* Description cannot be blank.";
    } else {
        document.getElementById('description-errorid').innerHTML = "";
    }

    if (fileInput.files.length === 0) {
        isFormValid = false;
        document.getElementById('file-upload-errorid').innerHTML = "* Please upload at least one photo.";
    } else if (fileInput.files.length > 5) {
        isFormValid = false;
        document.getElementById('file-upload-errorid').innerHTML = "* You can upload a maximum of 5 photos.";
    } else {
        document.getElementById('file-upload-errorid').innerHTML = "";
    }

    if (!isFormValid) {
        event.preventDefault(); 
    }
}
const form = document.getElementById('formid');

if (form) {
    form.addEventListener('submit', validateForm);
}

function validateForm(event) {
    const prahaSelect = document.getElementById('praha-selectid');
    const districtSelect = document.getElementById('districtid');
    const layoutSelect = document.getElementById('layoutid');
    const areaInput = document.getElementById('areaid');
    const priceInput = document.getElementById('priceid');
    const descriptionInput = document.getElementById('descriptionid');
    const imagesInput = document.getElementById('file-upload');
    
    let isValid = true;

    // Clear all error classes
    prahaSelect.classList.remove('error-input');
    districtSelect.classList.remove('error-input');
    layoutSelect.classList.remove('error-input');
    areaInput.classList.remove('error-input');
    priceInput.classList.remove('error-input');
    descriptionInput.classList.remove('error-input');
    imagesInput.classList.remove('error-input-file');

    // Praha validation
    if (prahaSelect.value === '') {
        isValid = false;
        prahaSelect.classList.add('error-input');
        document.getElementById('praha-select-errorid').innerHTML = '* Prague district is required.';
    } else {
        document.getElementById('praha-select-errorid').innerHTML = '';
    }

    // District validation
    if (districtSelect.value === '') {
        isValid = false;
        districtSelect.classList.add('error-input');
        document.getElementById('district-errorid').innerHTML = '* Specific district is required.';
    } else {
        document.getElementById('district-errorid').innerHTML = '';
    }

    // Layout validation
    if (layoutSelect.value === '') {
        isValid = false;
        layoutSelect.classList.add('error-input');
        document.getElementById('layout-errorid').innerHTML = '* Layout is required.';
    } else {
        document.getElementById('layout-errorid').innerHTML = '';
    }

    // Area validation
    if (areaInput.value.trim() === '') {
        isValid = false;
        areaInput.classList.add('error-input');
        document.getElementById('area-errorid').innerHTML = '* Area is required.';
    } else if (parseInt(areaInput.value) <= 0) {
        isValid = false;
        areaInput.classList.add('error-input');
        document.getElementById('area-errorid').innerHTML = '* Area must be a positive number.';
    } else {
        document.getElementById('area-errorid').innerHTML = '';
    }

    // Price validation
    if (priceInput.value.trim() === '') {
        isValid = false;
        priceInput.classList.add('error-input');
        document.getElementById('price-errorid').innerHTML = '* Price is required.';
    } else if (parseInt(priceInput.value) <= 0) {
        isValid = false;
        priceInput.classList.add('error-input');
        document.getElementById('price-errorid').innerHTML = '* Price must be a positive number.';
    } else {
        document.getElementById('price-errorid').innerHTML = '';
    }

    // Description validation
    const descriptionRegex = /^[\p{L}\p{N}\s.,!?;:()\-–—'\"\/\n\r]+$/u;
    if (descriptionInput.value.trim() === '') {
        isValid = false;
        descriptionInput.classList.add('error-input');
        document.getElementById('description-errorid').innerHTML = '* Description is required.';
    } else if (descriptionInput.value.trim().length < 20) {
        isValid = false;
        descriptionInput.classList.add('error-input');
        document.getElementById('description-errorid').innerHTML = '* Description must be at least 20 characters.';
    } else if (!descriptionRegex.test(descriptionInput.value)) {
        isValid = false;
        descriptionInput.classList.add('error-input');
        document.getElementById('description-errorid').innerHTML = '* Description contains invalid characters. Only letters, numbers, spaces, and basic punctuation are allowed.';
    } else {
        document.getElementById('description-errorid').innerHTML = '';
    }

    // Images validation
    if (imagesInput.files.length === 0) {
        isValid = false;
        imagesInput.classList.add('error-input-file');
        document.getElementById('file-upload-errorid').innerHTML = '* At least one image is required.';
    } else {
        document.getElementById('file-upload-errorid').innerHTML = '';
    }

    if (!isValid) {
        event.preventDefault();
    }
}

// Real-time validation - remove error styling when user starts typing/selecting
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#praha-selectid, #districtid, #layoutid, #areaid, #priceid, #descriptionid, #file-upload');
    
    inputs.forEach(input => {
        if (input.type === 'file') {
            input.addEventListener('change', function() {
                this.classList.remove('error-input-file');
            });
        } else {
            input.addEventListener('input', function() {
                this.classList.remove('error-input');
            });
            input.addEventListener('change', function() {
                this.classList.remove('error-input');
            });
        }
    });
});
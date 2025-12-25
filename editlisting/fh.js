// Form validation
const form = document.getElementById('form');
const layoutSelect = document.getElementById('layout');
const areaInput = document.getElementById('area');
const priceInput = document.getElementById('price');
const descriptionInput = document.getElementById('description');

form.addEventListener('submit', function(e) {
    let isValid = true;

    // Praha validation
    if (prahaSelect.value === '') {
        prahaSelect.classList.add('error-input');
        isValid = false;
    } else {
        prahaSelect.classList.remove('error-input');
    }

    // District validation
    if (districtSelect.value === '') {
        districtSelect.classList.add('error-input');
        isValid = false;
    } else {
        districtSelect.classList.remove('error-input');
    }

    // Layout validation
    if (layoutSelect.value === '') {
        layoutSelect.classList.add('error-input');
        isValid = false;
    } else {
        layoutSelect.classList.remove('error-input');
    }

    // Area validation
    if (areaInput.value === '' || parseInt(areaInput.value) <= 0) {
        areaInput.classList.add('error-input');
        isValid = false;
    } else {
        areaInput.classList.remove('error-input');
    }

    // Price validation
    if (priceInput.value === '' || parseInt(priceInput.value) <= 0) {
        priceInput.classList.add('error-input');
        isValid = false;
    } else {
        priceInput.classList.remove('error-input');
    }

    // Description validation
    if (descriptionInput.value.trim() === '') {
        descriptionInput.classList.add('error-input');
        isValid = false;
    } else {
        descriptionInput.classList.remove('error-input');
    }

    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields correctly.');
    }
});

// Remove error styling on input
[prahaSelect, districtSelect, layoutSelect, areaInput, priceInput, descriptionInput].forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('error-input');
    });
    input.addEventListener('change', function() {
        this.classList.remove('error-input');
    });
});
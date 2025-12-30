document.addEventListener('DOMContentLoaded', function() {
    const prahaSelect = document.getElementById('praha');
    const districtSelect = document.getElementById('district');
    const districtOptgroups = Array.from(districtSelect.querySelectorAll('optgroup'));

    // Store the initial district value
    const initialDistrict = districtSelect.value;

    // Clear and reset district select
    const resetDistrictSelect = () => {
        districtSelect.innerHTML = '<option value="">Select District</option>';
        districtSelect.disabled = true;
    };

    prahaSelect.addEventListener('change', function(e) {
        const prahaValue = e.target.value;

        resetDistrictSelect();

        if (prahaValue !== "") {
            const targetGroup = districtOptgroups.find(group => group.label === prahaValue);
            
            if (targetGroup) {
                const allOptions = targetGroup.querySelectorAll('option');
                allOptions.forEach(function(option) {
                    districtSelect.appendChild(option.cloneNode(true));
                });
                districtSelect.disabled = false;
            }
        }
    });

    // Trigger on page load if praha is already selected
    if (prahaSelect.value !== '') {
        prahaSelect.dispatchEvent(new Event('change'));
        
        // Restore the initial district value after the change event
        setTimeout(() => {
            if (initialDistrict) {
                districtSelect.value = initialDistrict;
            }
        }, 0);
    }

    // Form validation
    const form = document.getElementById('form');
    const layoutSelect = document.getElementById('layout');
    const areaInput = document.getElementById('area');
    const priceInput = document.getElementById('price');
    const descriptionInput = document.getElementById('description');

    // Error display functions
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.error');
        
        input.classList.add('error-input');
        if (errorDiv && message) {
            errorDiv.textContent = '* ' + message;
            errorDiv.style.display = 'block';
        }
    }

    function clearError(input) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.error');
        
        input.classList.remove('error-input');
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
        }
    }

    function clearAllErrors() {
        const allInputs = form.querySelectorAll('input, select, textarea');
        allInputs.forEach(input => clearError(input));
    }

    // Real-time validation on input
    prahaSelect.addEventListener('change', function() {
        if (this.value !== '') {
            clearError(this);
        }
    });

    districtSelect.addEventListener('change', function() {
        if (this.value !== '') {
            clearError(this);
        }
    });

    layoutSelect.addEventListener('change', function() {
        if (this.value !== '') {
            clearError(this);
        }
    });

    areaInput.addEventListener('input', function() {
        if (this.value.trim() !== '' && parseInt(this.value) > 0) {
            clearError(this);
        }
    });

    priceInput.addEventListener('input', function() {
        if (this.value.trim() !== '' && parseInt(this.value) > 0) {
            clearError(this);
        }
    });

    descriptionInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            clearError(this);
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        clearAllErrors();
        let isValid = true;
        let firstErrorField = null;

        // Praha validation
        if (prahaSelect.value === '') {
            showError(prahaSelect, 'Prague district is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = prahaSelect;
        }

        // District validation
        if (districtSelect.value === '') {
            showError(districtSelect, 'Specific district is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = districtSelect;
        }

        // Layout validation
        if (layoutSelect.value === '') {
            showError(layoutSelect, 'Layout is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = layoutSelect;
        }

        // Area validation
        if (areaInput.value.trim() === '') {
            showError(areaInput, 'Area is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = areaInput;
        } else if (parseInt(areaInput.value) <= 0) {
            showError(areaInput, 'Area must be a positive number.');
            isValid = false;
            if (!firstErrorField) firstErrorField = areaInput;
        }

        // Price validation
        if (priceInput.value.trim() === '') {
            showError(priceInput, 'Price is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = priceInput;
        } else if (parseInt(priceInput.value) <= 0) {
            showError(priceInput, 'Price must be a positive number.');
            isValid = false;
            if (!firstErrorField) firstErrorField = priceInput;
        }

        // Description validation
        const descriptionRegex = /^[\p{L}\p{N}\s.,!?;:()\-–—'"\/]+$/u;
        if (descriptionInput.value.trim() === '') {
            showError(descriptionInput, 'Description is required.');
            isValid = false;
            if (!firstErrorField) firstErrorField = descriptionInput;
        } else if (descriptionInput.value.trim().length < 20) {
            showError(descriptionInput, 'Description must be at least 20 characters.');
            isValid = false;
            if (!firstErrorField) firstErrorField = descriptionInput;
        } else if (!descriptionRegex.test(descriptionInput.value)) {
            showError(descriptionInput, 'Description contains invalid characters. Only letters, numbers, spaces, and basic punctuation are allowed.');
            isValid = false;
            if (!firstErrorField) firstErrorField = descriptionInput;
        }

        if (!isValid) {
            e.preventDefault();
            if (firstErrorField) {
                firstErrorField.focus();
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});


const form = document.getElementById('form');

if (form) {
    form.addEventListener('submit', validateForm);
}

function validateForm(event) {
    const firstnameInput = document.getElementById('firstname');
    const surnameInput = document.getElementById('surname');
    const emailInput = document.getElementById('email');
    
    let isValid = true;

    // Clear all error classes
    firstnameInput.classList.remove('error-input');
    surnameInput.classList.remove('error-input');
    emailInput.classList.remove('error-input');

    // First name validation
    const nameRegex = /^[\p{L}\s'-]+$/u;
    if (!firstnameInput.value.trim()) {
        isValid = false;
        firstnameInput.classList.add('error-input');
        document.getElementById('firstname_error').innerHTML = '* First name cannot be blank';
    } else if (!nameRegex.test(firstnameInput.value.trim())) {
        isValid = false;
        firstnameInput.classList.add('error-input');
        document.getElementById('firstname_error').innerHTML = '* First name can only contain letters, spaces, hyphens, and apostrophes';
    } else {
        document.getElementById('firstname_error').innerHTML = '';
    }

    // Surname validation
    if (!surnameInput.value.trim()) {
        isValid = false;
        surnameInput.classList.add('error-input');
        document.getElementById('surname_error').innerHTML = '* Surname cannot be blank';
    } else if (!nameRegex.test(surnameInput.value.trim())) {
        isValid = false;
        surnameInput.classList.add('error-input');
        document.getElementById('surname_error').innerHTML = '* Surname can only contain letters, spaces, hyphens, and apostrophes';
    } else {
        document.getElementById('surname_error').innerHTML = '';
    }

    // Email validation
    if (!emailInput.value.trim()) {
        isValid = false;
        emailInput.classList.add('error-input');
        document.getElementById('email_error').innerHTML = '* Email cannot be blank';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
        isValid = false;
        emailInput.classList.add('error-input');
        document.getElementById('email_error').innerHTML = '* Invalid email format';
    } else {
        document.getElementById('email_error').innerHTML = '';
    }

    if (!isValid) {
        event.preventDefault();
    }
}

// Real-time validation - remove error styling when user starts typing
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#firstname, #surname, #email');
    const csrfErrorDiv = document.getElementById('csrf-error');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error-input');
        });
    });

    if (csrfErrorDiv) {
        document.addEventListener('input', function() {
            csrfErrorDiv.classList.remove('error-input');
            csrfErrorDiv.innerHTML = '';
        });
    }
});
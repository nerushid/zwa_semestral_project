const form = document.getElementById('form');

if (form) {
    form.addEventListener('submit', validateForm);
}

function validateForm(event) {
    const currentPwdInput = document.getElementById('current-password');
    const newPwdInput = document.getElementById('new-password');
    const confirmPwdInput = document.getElementById('confirm-password');
    
    let isValid = true;

    // Clear all error classes
    currentPwdInput.classList.remove('error-input');
    newPwdInput.classList.remove('error-input');
    confirmPwdInput.classList.remove('error-input');

    // Current password validation
    if (!currentPwdInput.value) {
        isValid = false;
        currentPwdInput.classList.add('error-input');
        document.getElementById('current_password_error').innerHTML = '* Current password cannot be blank';
    } else if (currentPwdInput.value.length < 6) {
        isValid = false;
        currentPwdInput.classList.add('error-input');
        document.getElementById('current_password_error').innerHTML = '* Current password must be at least 6 characters';
    } else {
        document.getElementById('current_password_error').innerHTML = '';
    }

    // New password validation
    if (!newPwdInput.value) {
        isValid = false;
        newPwdInput.classList.add('error-input');
        document.getElementById('new_password_error').innerHTML = '* New password cannot be blank';
    } else if (newPwdInput.value.length < 6) {
        isValid = false;
        newPwdInput.classList.add('error-input');
        document.getElementById('new_password_error').innerHTML = '* New password must be at least 6 characters';
    } else {
        document.getElementById('new_password_error').innerHTML = '';
    }

    // Confirm password validation
    if (!confirmPwdInput.value) {
        isValid = false;
        confirmPwdInput.classList.add('error-input');
        document.getElementById('confirm_password_error').innerHTML = '* Please confirm your new password';
    } else if (newPwdInput.value !== confirmPwdInput.value) {
        isValid = false;
        confirmPwdInput.classList.add('error-input');
        document.getElementById('confirm_password_error').innerHTML = '* Passwords do not match';
    } else {
        document.getElementById('confirm_password_error').innerHTML = '';
    }

    if (!isValid) {
        event.preventDefault();
    }
}

// Real-time validation - remove error styling when user starts typing
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#current-password, #new-password, #confirm-password');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error-input');
        });
    });
});

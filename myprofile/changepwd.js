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
    } else {
        const errors = [];
        
        if (newPwdInput.value.length < 8) {
            errors.push("at least 8 characters");
        }
        
        if (newPwdInput.value.length > 72) {
            errors.push("maximum 72 characters");
        }
        
        if (!/[a-zA-Z]/.test(newPwdInput.value)) {
            errors.push("at least one letter");
        }
        
        if (!/[0-9]/.test(newPwdInput.value)) {
            errors.push("at least one number");
        }
        
        if (errors.length > 0) {
            isValid = false;
            newPwdInput.classList.add('error-input');
            document.getElementById('new_password_error').innerHTML = '* Password must contain: ' + errors.join(", ") + '.';
        } else {
            document.getElementById('new_password_error').innerHTML = '';
        }
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

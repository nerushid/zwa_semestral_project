const form = document.getElementById("form1")

if (form) {
    form.addEventListener("submit", chekingInputs)
}

function chekingInputs(event) {
    const firstNameInput = document.getElementById("nameid")
    const lastNameInput = document.getElementById("surnameid")
    const emailInput = document.getElementById("emailid")
    const passwordInput = document.getElementById("passwordid")
    const password2Input = document.getElementById("password-confirmid")
    
    const firstNameValue = firstNameInput.value
    const lastNameValue = lastNameInput.value
    const emailValue = emailInput.value
    const passwordValue = passwordInput.value
    const password2Value = password2Input.value
    
    let isFormValid = true

    // Clear all error classes
    firstNameInput.classList.remove('error-input')
    lastNameInput.classList.remove('error-input')
    emailInput.classList.remove('error-input')
    passwordInput.classList.remove('error-input')
    password2Input.classList.remove('error-input')

    // First Name Validation
    const nameRegex = /^[\p{L}\s'-]+$/u
    if (firstNameValue.trim() === "") {
        isFormValid = false
        firstNameInput.classList.add('error-input')
        document.getElementById("first-name-error").innerHTML = "* First name cannot be blank"
    } else if (!nameRegex.test(firstNameValue.trim())) {
        isFormValid = false
        firstNameInput.classList.add('error-input')
        document.getElementById("first-name-error").innerHTML = "* First name can only contain letters, spaces, hyphens, and apostrophes"
    } else {
        document.getElementById("first-name-error").innerHTML = ""
    }

    // Last Name Validation
    if (lastNameValue.trim() === "") {
        isFormValid = false
        lastNameInput.classList.add('error-input')
        document.getElementById("surname-error").innerHTML = "* Last name cannot be blank"
    } else if (!nameRegex.test(lastNameValue.trim())) {
        isFormValid = false
        lastNameInput.classList.add('error-input')
        document.getElementById("surname-error").innerHTML = "* Last name can only contain letters, spaces, hyphens, and apostrophes"
    } else {
        document.getElementById("surname-error").innerHTML = ""
    }

    // Email Validation
    if (emailValue.trim() === "") {
        isFormValid = false
        emailInput.classList.add('error-input')
        document.getElementById("email-error").innerHTML = "* Email cannot be blank"
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue.trim())) {
        isFormValid = false
        emailInput.classList.add('error-input')
        document.getElementById("email-error").innerHTML = "* Invalid email format"
    } else {
        document.getElementById("email-error").innerHTML = ""
    }

    // Password Validation
    if (passwordValue === "") {
        isFormValid = false
        passwordInput.classList.add('error-input')
        document.getElementById("password-error").innerHTML = "* Password cannot be blank"
    } else {
        const errors = []
        
        if (passwordValue.length < 8) {
            errors.push("at least 8 characters")
        }
        
        if (passwordValue.length > 72) {
            errors.push("maximum 72 characters")
        }
        
        if (!/[a-zA-Z]/.test(passwordValue)) {
            errors.push("at least one letter")
        }
        
        if (!/[0-9]/.test(passwordValue)) {
            errors.push("at least one number")
        }
        
        if (errors.length > 0) {
            isFormValid = false
            passwordInput.classList.add('error-input')
            document.getElementById("password-error").innerHTML = "* Password must contain: " + errors.join(", ") + "."
        } else {
            document.getElementById("password-error").innerHTML = ""
        }
    }

    // Confirm Password Validation
    if (password2Value === "") {
        isFormValid = false
        password2Input.classList.add('error-input')
        document.getElementById("password-confirm-error").innerHTML = "* Please confirm your password"
    } else if (passwordValue !== password2Value) {
        isFormValid = false
        password2Input.classList.add('error-input')
        document.getElementById("password-confirm-error").innerHTML = "* Passwords do not match"
    } else {
        document.getElementById("password-confirm-error").innerHTML = ""
    }
    
    if (!isFormValid) {
        event.preventDefault()
    }
}

// Real-time validation - remove error styling when user starts typing
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('#nameid, #surnameid, #emailid, #passwordid, #password-confirmid')
    const csrfErrorDiv = document.getElementById('csrf-error')

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error-input')
        })
    })

    if (csrfErrorDiv) {
        document.addEventListener('input', function() {
            csrfErrorDiv.classList.remove('error-input')
            csrfErrorDiv.innerHTML = ''
        })
    }
})
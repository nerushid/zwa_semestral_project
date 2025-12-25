const form = document.getElementById("form");

if (form) {
    form.addEventListener("submit", checkingInputs)
}

function checkingInputs(event) {
    const emailInput = document.getElementById("emailid")
    const passwordInput = document.getElementById("passwordid")
    let isFormValid = true
    
    // Clear error classes first
    emailInput.classList.remove("error-input")
    passwordInput.classList.remove("error-input")
    
    // Email Validation
    if (!emailInput.value.trim()) {
        isFormValid = false
        emailInput.classList.add("error-input")
        document.getElementById("email-error").innerHTML = "* Email cannot be blank"
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
        isFormValid = false
        emailInput.classList.add("error-input")
        document.getElementById("email-error").innerHTML = "* Invalid email format"
    } else {
        document.getElementById("email-error").innerHTML = ""
    }

    // Password Validation
    if (!passwordInput.value.trim()) {
        isFormValid = false
        passwordInput.classList.add("error-input")
        document.getElementById("password-error").innerHTML = "* Password cannot be blank"
    } else {
        document.getElementById("password-error").innerHTML = ""
    }

    if (!isFormValid) {
        event.preventDefault()
    }
}

// Real-time validation - remove error styling when user starts typing
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('emailid')
    const passwordInput = document.getElementById('passwordid')
    
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            this.classList.remove('error-input')
        })
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            this.classList.remove('error-input')
        })
    }
})
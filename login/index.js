const form = document.getElementById("form");

if (form) {
    form.addEventListener("submit", chekingInputs)
}

function chekingInputs(event) {
    const emailInput = document.getElementById("emailid")
    const passwordInput = document.getElementById("passwordid")
    let isFormValid = true
    
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
        emailInput.classList.remove("error-input")
        document.getElementById("email-error").innerHTML = ""
    }

    // Password Validation
    if (!passwordInput.value.trim()) {
        isFormValid = false
        passwordInput.classList.add("error-input")
        document.getElementById("password-error").innerHTML = "* Password cannot be blank"
    } else {
        passwordInput.classList.remove("error-input")
        document.getElementById("password-error").innerHTML = ""
    }

    if (document.getElementById("password-error").innerHTML === "" && document.getElementById("email-error").innerHTML === "") {
        document.getElementById("password-error")?.remove();
        document.getElementById("email-error")?.remove();
    }
    if (!isFormValid) {
        event.preventDefault()
        document.querySelector(".phperror")?.remove()   
    }
}
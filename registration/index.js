const form = document.getElementById("form1")

if (form) {
	form.addEventListener("submit", chekingInputs)
}

function chekingInputs(event) {
    const firstNameValue = document.getElementById("nameid").value
    const lastNameValue = document.getElementById("surnameid").value
    const phoneNumberValue = document.getElementById("numberid").value
    const emailValue = document.getElementById("emailid").value
    const passwordValue = document.getElementById("passwordid").value
    const password2Value = document.getElementById("password-confirmid").value
    let isFormValid = true

    // First Name Validation
    if (firstNameValue.trim() == "") {
        isFormValid = false
        document.getElementById("first-name-error").innerHTML = "* First name cannot be blank"
    } else {
        document.getElementById("first-name-error").innerHTML = ""
    }

    // Last Name Validation
    if (lastNameValue.trim() == "") {
        isFormValid = false
        document.getElementById("surname-error").innerHTML = "* Last name cannot be blank"
    } else {
        document.getElementById("surname-error").innerHTML = ""
    }

    // Phone Number Validation
    if (phoneNumberValue.trim() === "") {
        isFormValid = false
        document.getElementById("phone-number-error").innerHTML = "* Phone number cannot be blank"
    } else if (!/^\+?[\d\s\-()]{7,20}$/.test(phoneNumberValue)) {
        isFormValid = false
        document.getElementById("phone-number-error").innerHTML = "* Invalid phone number"
    } else {     
        document.getElementById("phone-number-error").innerHTML = ""
    }

    // Email Validation
    if (emailValue.trim() === "") {
        isFormValid = false
        document.getElementById("email-error").innerHTML = "* Email cannot be blank"
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
        isFormValid = false
        document.getElementById("email-error").innerHTML = "* Invalid email format"
    } else {
        document.getElementById("email-error").innerHTML = ""
    }

    // Password Validation
    if (passwordValue == "") {
        isFormValid = false
        document.getElementById("password-error").innerHTML = "* Password cannot be blank"
    } else if (passwordValue.length < 6) {
        isFormValid = false
        document.getElementById("password-error").innerHTML = "* Password must be at least 6 characters long"
    } else {
        document.getElementById("password-error").innerHTML = ""
    }

    // Confirm Password Validation
    if (password2Value == "") {
        isFormValid = false
        document.getElementById("password-confirm-error").innerHTML = "* Please confirm your password"
    } else if (passwordValue !== password2Value) {
        isFormValid = false
        document.getElementById("password-confirm-error").innerHTML = "* Passwords do not match"
    } else {
        document.getElementById("password-confirm-error").innerHTML = ""
    }
    
    
    if (!isFormValid) {
        event.preventDefault()
    }
}
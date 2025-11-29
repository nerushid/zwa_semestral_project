const form = document.getElementById('form');

if (form) {
    form.addEventListener('submit', chekingInputs);
}

function chekingInputs(event) {
    const firstNameValue = document.getElementById('firstname').value;
    const lastNameValue = document.getElementById('surname').value;
    const emailValue = document.getElementById('email').value;
    let isFormValid = true;

    // First Name Validation
    if (firstNameValue.trim() === '') {
        isFormValid = false;
        document.getElementById('firstname_error').innerHTML = '* First name cannot be blank';
    } else if (!/^[\p{L}\s'-]+$/u.test(firstNameValue.trim())) {
        isFormValid = false;
        document.getElementById('firstname_error').innerHTML = '* Invalid first name format';
    } else {
        document.getElementById('firstname_error').innerHTML = '';
    }

    // Last Name Validation
    if (lastNameValue.trim() === '') {
        isFormValid = false;
        document.getElementById('surname_error').innerHTML = '* Surname cannot be blank';
    } else if (!/^[\p{L}\s'-]+$/u.test(lastNameValue.trim())) {
        isFormValid = false;
        document.getElementById('surname_error').innerHTML = '* Invalid surname format';
    } else {
        document.getElementById('surname_error').innerHTML = '';
    }
    

    // Email Validation
    if (emailValue.trim() === '') {
        isFormValid = false;
        document.getElementById('email_error').innerHTML = '* Email cannot be blank';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue.trim())) {
        isFormValid = false;
        document.getElementById('email_error').innerHTML = '* Invalid email format';
    } else {
        document.getElementById('email_error').innerHTML = '';
    }

    if (!isFormValid) {
        event.preventDefault();
    }
}
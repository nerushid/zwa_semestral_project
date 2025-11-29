const form = document.getElementById('form');

if (form) {
    form.addEventListener('submit', chekingInputs);
}

function chekingInputs(event) {
    const firstNameInput = document.getElementById('firstname');
    const lastNameInput = document.getElementById('surname');
    const emailInput = document.getElementById('email');

    const firstNameValue = firstNameInput.value;
    const lastNameValue = lastNameInput.value;
    const emailValue = emailInput.value;
    let isFormValid = true;

    // First Name Validation
    if (firstNameValue.trim() === '') {
        isFormValid = false;
        document.getElementById('firstname_error').innerHTML = '* First name cannot be blank';
        firstNameInput.classList.add('error-input');
    } else if (!/^[\p{L}\s'-]+$/u.test(firstNameValue.trim())) {
        isFormValid = false;
        document.getElementById('firstname_error').innerHTML = '* Invalid first name format';
        firstNameInput.classList.add('error-input');
    } else {
        document.getElementById('firstname_error').innerHTML = '';
        firstNameInput.classList.remove('error-input');
    }

    // Last Name Validation
    if (lastNameValue.trim() === '') {
        isFormValid = false;
        document.getElementById('surname_error').innerHTML = '* Surname cannot be blank';
        lastNameInput.classList.add('error-input');
    } else if (!/^[\p{L}\s'-]+$/u.test(lastNameValue.trim())) {
        isFormValid = false;
        document.getElementById('surname_error').innerHTML = '* Invalid surname format';
        lastNameInput.classList.add('error-input');
    } else {
        document.getElementById('surname_error').innerHTML = '';
        lastNameInput.classList.remove('error-input');
    }
    

    // Email Validation
    if (emailValue.trim() === '') {
        isFormValid = false;
        document.getElementById('email_error').innerHTML = '* Email cannot be blank';
        emailInput.classList.add('error-input');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue.trim())) {
        isFormValid = false;
        document.getElementById('email_error').innerHTML = '* Invalid email format';
        emailInput.classList.add('error-input');
    } else {
        document.getElementById('email_error').innerHTML = '';
        emailInput.classList.remove('error-input');
    }

    if (!isFormValid) {
        event.preventDefault();
    }
}
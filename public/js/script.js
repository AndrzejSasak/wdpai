const form = document.querySelector("form");

const nameInput = form.querySelector('div.input-container input[name="name"]');
const surnameInput = form.querySelector('div.input-container input[name="surname"]');
const emailInput = form.querySelector('div.input-container input[name="email"]');
const passwordInput = form.querySelector('div.input-container input[name="password"]')
const confirmPasswordInput = form.querySelector('div.input-container input[name="confirm-password"]');
const messages = form.querySelector('div.messages')

function isEmail(email) {
    return /^\S+@\S+\.\S+$/.test(email);
}

function arePasswordSame(password, confirmPassword) {
    if(password === confirmPassword) {
        messages.innerHTML = "";
        return true;
    } else {
        messages.innerHTML = "Passwords do not match";
        return false;
    }

}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function areNameAndSurnameValid() {
    return nameInput.value.length > 0 && surnameInput.value.length > 0;
}

function isPasswordEligible(password) {
    if (password.length < 6) {
        messages.innerHTML = "Password is too short"
        return false;
    } else if (password.length > 50) {
        messages.innerHTML = "Password is too long"
        return false;
    } else if (!/\d/.test(password)) {
        messages.innerHTML = "Password does not include a number"
        return false;
    } else if (!/[a-zA-Z]/.test(password)) {
        messages.innerHTML = "Password does not include a letter"
        return false;
    } else if (/[^a-zA-Z0-9!\@\#\$\%\^\&\*\(\)\_\+]/.test(password)) {
        messages.innerHTML = "Password includes illegal character"
        return false;
    } else if(!/[A-Z]/.test(password)) {
        messages.innerHTML = "Password does not include a capital letter"
        return false;
    }
    messages.innerHTML = "";
    return true;
}

function validateEmail() {
    setTimeout( function() {
            markValidation(emailInput, isEmail(emailInput.value))
        },
        1000);

}

function validateConfirmPassword() {
    setTimeout( function() {
            const condition = arePasswordSame(
                passwordInput.value,
                confirmPasswordInput.value
            );
            console.log(condition);
            markValidation(confirmPasswordInput, condition)
        },
        1000);
}

function validatePassword() {
    setTimeout(function() {
        const condition = isPasswordEligible(passwordInput.value);
        markValidation(passwordInput, condition)
    },
    1000);
}

function validateForm() {
    if(isPasswordEligible(passwordInput.value)
        && arePasswordSame(passwordInput.value, confirmPasswordInput.value)
        && isEmail(emailInput.value)
        && areNameAndSurnameValid()) {
        return true;
    } else {
        messages.innerHTML = "Input is not valid";
        return false;
    }
}

emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePassword);
confirmPasswordInput.addEventListener('keyup', validateConfirmPassword);
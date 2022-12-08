const form = document.querySelector("form");

const emailInput = form.querySelector('div.input-container input[name="email"]');
console.log(emailInput);
const confirmPasswordInput = form.querySelector('div.input-container input[name="confirm-password"]');

function isEmail(email) {
    return /\S+@\S+.\S+/.test(email);
}

function arePasswordSame(password, confirmPassword) {
    return password === confirmPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

emailInput.addEventListener('keyup', function () {
    setTimeout( function() {
        markValidation(emailInput, isEmail(emailInput.value))
    }
    , 1000);

});

confirmPasswordInput.addEventListener('keyup', function () {
    setTimeout( function() {
        const condition = !arePasswordSame(
            confirmPasswordInput.previousElementSibling.value,
            confirmPasswordInput.value
        );
        markValidation(confirmPasswordInput, condition)
    }
    , 1000);
});
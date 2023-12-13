const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');

form.addEventListener('submit', e => {
    e.preventDefault();

    validateInputs();
});

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = message;
    inputControl.classList.add('error');
    inputControl.classList.remove('success')
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};



const validateInputs = () => {
    const usernameValue = username.value.trim();
   
    const passwordValue = password.value.trim();
    

    if(usernameValue === '') {
        setError(username, 'El usuario es requerido');
    } else {
        setSuccess(username);
    }



    if(passwordValue === '') {
        setError(password, 'La contraseña es requerida');
    } else if (passwordValue.length < 8 ) {
        setError(password, 'La contraseña no puede ser menor a 8 caracteres')
    } else {
        setSuccess(password);
    }

  

};
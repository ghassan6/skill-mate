document.addEventListener('DOMContentLoaded', function() { 

    let form = document.getElementById('login-form');
    let loginBtn = document.getElementById('login-btn');


    document.querySelectorAll('.form-control').forEach(function(input) {
        input.addEventListener('keyup', checkInput)   
    
    })

    function checkInput() {
        let filled = true;
        document.querySelectorAll('.form-control').forEach(function(input) {
    
                if (input.value === "") filled = false;
            })

        filled ? loginBtn.removeAttribute('disabled') : loginBtn.setAttribute('disabled', 'true');
    }

    form.addEventListener("submit" , (event) => {
        event.preventDefault();
        let valid = true;
        if(!validateEmail()) valid = false;

        
        if(valid) form.submit()
    })

    function validateEmail() {
        let email = document.getElementById('email');

        if(!(/(?=(.*[@])(?=(.*[.])))/).test(email.value)) {
            displayError("Enter a valid email" , email);
            return false;
        }

        return true;
    }

    function displayError(msg, inputElement) {

        let parent = inputElement.parentElement;  

        let existingError = parent.querySelector('.text-danger');
        if (existingError) {
            existingError.innerText = msg;  
            return;
        }
        let error = document.createElement('p');
        error.classList.add('text-danger');
        error.innerText = msg;
        parent.appendChild(error);
    }
});
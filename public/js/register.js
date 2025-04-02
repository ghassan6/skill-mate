document.addEventListener('DOMContentLoaded', function() {
    // declate variables
    let form = document.getElementById('register-form');
    let regBtn = document.getElementById('register-btn');

    document.querySelectorAll('.form-control, .form-check-input').forEach(function(input) {
        input.addEventListener('keyup', checkInput)   
        input.addEventListener('change', checkInput)
      
    })

    function checkInput() {
        let filled = true;
         document.querySelectorAll('.form-control, .form-check-input').forEach(function(input) {
                if(input.type === "checkbox") {
                    if (!input.checked) filled = false;
                    
                }  
                else if (input.value.trim() === "") filled = false;
            })

        filled ? regBtn.removeAttribute('disabled') : regBtn.setAttribute('disabled', 'true');
    }


    form.addEventListener("submit" , (event) => {
        event.preventDefault();
        let valid = true;
        if(!validateUsername()) valid = false;
        if(!validateEmail()) valid = false;
        if(!validatePassword()) valid = false;
        if(!validatePhone()) valid = false;

        
        if(valid) form.submit()
    })


    function validateUsername() {
    let username = document.getElementById('username');

        if(username.value.length < 5 ) {
            displayError("username must be 5 characters at least", username)
            return false;
        }
        return true;
    }

    function validateEmail() {
        let email = document.getElementById('email');

        if(!(/(?=(.*[@])(?=(.*[.])))/).test(email.value)) {
            displayError("Enter a valid email" , email);
            return false;
        }

        return true;
    }

    function validatePassword() {
        let password = document.getElementById('password');
        let confirm_password = document.getElementById('password_confirmation');

        if(password.value.length < 6 || password.value.length > 18) {
            displayError("Password must be bwtween 6 and 18 characters", password);
            return false;
        }

        if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+={}\[\]:;"'<>,.?/-]).{6,18}$/.test(password.value)) {
            displayError("Password must contain a capital letter, small letter and a special character, with no spaces", password)
            return false;
        }

        if(!(password.value === confirm_password.value)) {
            displayError("Passwords do not match", confirm_password)
            return false;
        }
        return true;

    }

    function validatePhone() {
        let phone = document.getElementById('phone');

        if(!/^(077|078|079)\d{7}$/.test(phone.value)) {
            displayError("Invalid Phone number", phone)
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
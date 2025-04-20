document.addEventListener('DOMContentLoaded', function() {
    console.log("Login JS loaded");
    let loginForm = document.getElementById('login-form');
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

    loginForm.addEventListener("submit" , (event) => {
        event.preventDefault();
        let valid = true;
        if(!validateEmail()) valid = false;


        if(valid) loginForm.submit()
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

     // Password toggle functionality
     const passwordToggle = document.querySelector('.password-toggle');
     const passwordInput = document.getElementById('password');

     if (passwordToggle && passwordInput) {
         passwordToggle.addEventListener('click', function() {
             const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
             passwordInput.setAttribute('type', type);
             this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
         });
     }

     // Form validation to enable/disable button


     if (loginForm && loginBtn) {
         const inputs = loginForm.querySelectorAll('input[required]');

         function checkForm() {
             let allValid = true;
             inputs.forEach(input => {
                 if (!input.value.trim()) {
                     allValid = false;
                 }
             });
             loginBtn.disabled = !allValid;
         }

         inputs.forEach(input => {
             input.addEventListener('input', checkForm);
         });

         // Initial check
         checkForm();
     }

     // Add focus class to form groups when input is focused
     const formGroups = document.querySelectorAll('.form-group');

     formGroups.forEach(group => {
         const input = group.querySelector('input');

         input.addEventListener('focus', () => {
             group.classList.add('focused');
         });

         input.addEventListener('blur', () => {
             group.classList.remove('focused');
         });
     });
});

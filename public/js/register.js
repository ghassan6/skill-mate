// document.addEventListener('DOMContentLoaded', function() {

//     // declate variables
//     let form = document.getElementById('register-form');
//     let regBtn = document.getElementById('register-btn');

//     document.querySelectorAll('.form-control, .form-check-input').forEach(function(input) {
//         input.addEventListener('keyup', checkInput)
//         input.addEventListener('change', checkInput)

//     })

//     function checkInput() {
//         let filled = true;
//          document.querySelectorAll('.form-control, .form-check-input').forEach(function(input) {
//                 if(input.type === "checkbox") {
//                     if (!input.checked) filled = false;

//                 }
//                 else if (input.value.trim() === "") filled = false;
//             })

//         filled ? regBtn.removeAttribute('disabled') : regBtn.setAttribute('disabled', 'true');
//     }


//     form.addEventListener("submit" , (event) => {
//         event.preventDefault();
//         let valid = true;
//         if(!validateUsername()) valid = false;
//         if(!validateEmail()) valid = false;
//         if(!validatePassword()) valid = false;
//         if(!validatePhone()) valid = false;


//         if(valid) form.submit()
//     })


//     function validateUsername() {
//     let username = document.getElementById('username');

//         if(username.value.length < 5 ) {
//             displayError("username must be 5 characters at least", username)
//             return false;
//         }
//         return true;
//     }

//     function validateEmail() {
//         let email = document.getElementById('email');

//         if(!(/(?=(.*[@])(?=(.*[.])))/).test(email.value)) {
//             displayError("Enter a valid email" , email);
//             return false;
//         }

//         return true;
//     }

//     function validatePassword() {
//         let password = document.getElementById('password');
//         let confirm_password = document.getElementById('password_confirmation');

//         if(password.value.length < 6 || password.value.length > 18) {
//             displayError("Password must be bwtween 6 and 18 characters", password);
//             return false;
//         }

//         if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+={}\[\]:;"'<>,.?/-]).{6,18}$/.test(password.value)) {
//             displayError("Password must contain a capital letter, small letter and a special character, with no spaces", password)
//             return false;
//         }

//         if(!(password.value === confirm_password.value)) {
//             displayError("Passwords do not match", confirm_password)
//             return false;
//         }
//         return true;

//     }

//     function validatePhone() {
//         let phone = document.getElementById('phone');

//         if(!/^(077|078|079)\d{7}$/.test(phone.value)) {
//             displayError("Invalid Phone number", phone)
//             return false;
//         }

//         return true;

//     }


//     function displayError(msg, inputElement) {

//         let parent = inputElement.parentElement;

//         let existingError = parent.querySelector('.text-danger');
//         if (existingError) {
//             existingError.innerText = msg;
//             return;
//         }
//         let error = document.createElement('p');
//         error.classList.add('text-danger');
//         error.innerText = msg;
//         parent.appendChild(error);
//     }

// });

document.addEventListener('DOMContentLoaded', function() {
    console.log('here')
    // Form Steps Navigation
    const steps = document.querySelectorAll('.form-step');
    const stepButtons = document.querySelectorAll('.step');
    const nextButtons = document.querySelectorAll('.btn-next');
    const prevButtons = document.querySelectorAll('.btn-prev');
    const progressFill = document.querySelector('.progress-fill');
    const registerForm = document.getElementById('register-form');

    // Password Strength Meter
    const passwordInput = document.getElementById('password');
    const strengthFill = document.querySelector('.strength-fill');
    const strengthText = document.querySelector('.strength-text span');

    // Terms Checkbox
    const termsCheckbox = document.getElementById('terms');
    const registerBtn = document.getElementById('register-btn');

    // Current step
    let currentStep = 1;
    const totalSteps = 3;

    // Initialize form
    showStep(currentStep);
    updateProgress();

    // Step navigation
    function showStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');

        stepButtons.forEach(btn => {
            const btnStep = parseInt(btn.getAttribute('data-step'));
            btn.classList.toggle('active', btnStep <= step);
        });
    }

    function updateProgress() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressFill.style.width = `${progress}%`;
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextStep = parseInt(this.getAttribute('data-next'));

            // Validate current step before proceeding
            if (validateStep(currentStep)) {
                currentStep = nextStep;
                showStep(currentStep);
                updateProgress();
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const prevStep = parseInt(this.getAttribute('data-prev'));
            currentStep = prevStep;
            showStep(currentStep);
            updateProgress();
        });
    });

    // Step validation
    function validateStep(step) {
        let isValid = true;
        const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);

        document.querySelectorAll('.err').forEach(function(error) {
            error.innerHTML = '';
        });

        if(step == 1) {
            let username = document.getElementById('username').value;
            let first_name = document.getElementById('first_name').value;
            let last_name = document.getElementById('last_name').value;
            if (username.length < 5 || username.length > 20) {
                showError('username', "Username must be between 5 and 15 characters");
                isValid = false;
            }

            if (first_name.length < 5 || first_name.length > 20) {
                showError('first_name', "First name must be between 5 and 20 characters");
                isValid = false;
            }

            if (last_name.length < 5 || last_name.length > 20) {
                showError('last_name', "Last name must be between 5 and 20 characters");
                isValid = false;
            }
        }


        // Additional validation for specific steps
        if (step === 2) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const phone = document.getElementById('phone').value.trim();

            if(!(/(?=(.*[@])(?=(.*[.])))/).test(email)) {
                showError("email" , 'Enter a valid email');
                isValid = false;
            }

            if(!(/^(078|079|077)\d{7}$/).test(phone)) {
                showError("phone" , 'The phone number must start with 078, 079, or 077 and be exactly 10 digits long');
                isValid = false;
            }

            if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/.test(password)) {
                showError("password" , 'Password must be one capital letter, one small letter and special character');
                isValid = false;
            }

            if (password !== confirmPassword) {
                showError("password_confirmation" , 'Passwords Do not match');
                isValid = false;
            }
        }

        return isValid;
    }

    // Password strength meter
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;

        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;

        // Complexity checks
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;

        // Update strength meter
        const strengthPercent = (strength / 6) * 100;
        strengthFill.style.width = `${strengthPercent}%`;

        // Update strength text and color
        if (strength <= 2) {
            strengthFill.style.backgroundColor = 'var(--error)';
            strengthText.textContent = 'Weak';
        } else if (strength <= 4) {
            strengthFill.style.backgroundColor = 'orange';
            strengthText.textContent = 'Medium';
        } else {
            strengthFill.style.backgroundColor = 'var(--success)';
            strengthText.textContent = 'Strong';
        }
    });

    // Terms checkbox validation
    termsCheckbox.addEventListener('change', function() {
        registerBtn.disabled = !this.checked;
    });

    // Form submission
    registerForm.addEventListener('submit', function(e) {
        if (!termsCheckbox.checked) {
            e.preventDefault();
            termsCheckbox.focus();
        }
    });

    // Initialize password toggles
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

     function showError(field, message) {
        let errorElement = document.getElementById(field + '-error');
        if (errorElement) {
            errorElement.innerHTML = message;
        }
    }
});

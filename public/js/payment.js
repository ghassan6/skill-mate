
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {

    let cardNumber = document.getElementById('cardNumber');
    let expiry = document.getElementById('cardExpiry');
    let cvv = document.getElementById('cardCvv');

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });



    // Format card number
    cardNumber.addEventListener('input', function(e) {
        this.value = this.value.replace(/\s/g, '').replace(/(\d{4})/g, '$1 ').trim();
    });

    // Format expiry date
    expiry.addEventListener('input', function(e) {
        let input = this.value.replace(/\D/g, '').slice(0, 4);
        if (input.length > 2) {
            this.value = input.slice(0, 2) + '/' + input.slice(2);
        } else {
            this.value = input;
        }
    });

    cvv.addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
    })

    // Form validation

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        let isValid = true;
        e.preventDefault()

        document.querySelectorAll('.err').forEach(err => {
            err.innerHTML = "";
        })
        if(!isValidCVV(cvv.value)) {
            showError('cvv', "Invalid CVV number")
            isValid = false;
        }
        if(!isValidExpiry(expiry.value)) {
            showError('expiry', 'Invalid expiray Date')
            isValid = false;
        }

        if(isValid) submitForm(this);
    });


    function isValidExpiry(expiry) {
        const [month, year] = expiry.split('/');

        if (!/^\d{2}\/\d{2}$/.test(expiry)) return false;

        const currentYear = new Date().getFullYear() % 100;
        const currentMonth = new Date().getMonth() + 1;

        const mm = parseInt(month, 10);
        const yy = parseInt(year, 10);

        if (mm < 1 || mm > 12) return false;
        if (yy < currentYear || (yy === currentYear && mm < currentMonth)) return false;

        return true;
    }

    function isValidCVV(cvv) {
        return /^\d{3,4}$/.test(cvv);
    }


    function showError(field, message) {
        let errorElement = document.getElementById(field + '-error');
        if (errorElement) {
            errorElement.innerHTML = message;
        }
    }

    function submitForm(form) {
        Swal.fire({
            title: "Payment Successful!",
            icon: "success",
            confirmButtonText: "OK",
            allowOutsideClick: false
          })
          .then(Result => {
            if(Result.isConfirmed) {
                form.submit()
            }
          })
    }
});


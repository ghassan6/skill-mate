// owner section


document.addEventListener('DOMContentLoaded', function() {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


// activate/ deactivate service

let activateBtn = document.getElementById('activate-btn');
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function toggleActivity(slug , isActive) {

    let action = isActive == 'active' ? 'Deactivate' : 'Activate';
    let color = isActive == 'active' ? '#dc3545': '#198754'   ;
    Swal.fire({
        title: `Do you want to ${action} this service?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: action,
        confirmButtonColor: color,
        cancelButtonColor:'rgb(95, 106, 116)',

        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            fetch(`/${slug}/activate`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire(`Service has been ${action}d`)
                    .then(() => window.location.reload())
                }
                else {
                    swal.fire("An Error ouccured plaese Try again");
                }
            })
        }
        });
}


    //   for promotion

    function selectPromotion(days, amount) {
        document.getElementById('promotionDays').value = days;
        document.getElementById('promotionAmount').value = amount;
        document.getElementById('proceedToPayment').disabled = false;

        // Highlight selected card
        document.querySelectorAll('.pricing-card').forEach(card => {
            card.classList.remove('bg-warning', 'bg-opacity-10');
            card.classList.add('border-warning');
        });
        event.target.closest('.pricing-card').classList.add('bg-warning', 'bg-opacity-10');
        event.target.closest('.pricing-card').classList.remove('border-warning');
    }

    // Reset form when modal is closed
    let promoteModal =  document.getElementById('promoteModal');

    if(promoteModal) {
        promoteModal.addEventListener('hidden.bs.modal', function () {
                document.getElementById('promotionForm').reset();
                document.getElementById('proceedToPayment').disabled = true;
                document.querySelectorAll('.pricing-card').forEach(card => {
                    card.classList.remove('bg-warning', 'bg-opacity-10');
                    card.classList.add('border-warning');
                });
            });

    }


function deleteService(service, userId) {
    console.log(service, userId)
    swal.fire({
        title: 'Are you sure You want to Delete this service?, This action can\'t be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'I am aware, proceed',
        confirmButtonColor: '#dc3545',
        cancelButtonColor:'rgb(95, 106, 116)',
    })
    .then(Result => {
        if(Result.isConfirmed) {
            fetch(`/services/${service}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire('Service Has benn deleted successfully')
                    .then(() => window.location.href = `/${userId}/services`)
                }
                else swal.fire('An Error occured, please Try again later')
            })
        }
    })
}

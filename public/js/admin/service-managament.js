const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function toggleStatus(service , status) {

    let text = status == 'active' ? 'The service will be availble for all users' : 'The service will be hidden from users';
    let color = status == 'active' ? '#1cb807' : '#d33';
    let action = status == 'active' ? 'Activate' : 'Deactivate';

    swal.fire({
        title: `Are you sure you want to ${action} This service?`,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${action}`,
        confirmButtonColor: color,
    })
    .then(Result => {
        if(Result.isConfirmed) {
            fetch(`/admin/services/${service}/activate`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire({
                        title: `Service has been ${action}ed`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }
                else swal.fire('An error occured, Please try again later')
            })
        }
    })
}

function confirmDelete(service) {

    swal.fire({
        title: "Destructive action!",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "I am aware, proceed",
    })
    .then(Result => {
        if(Result.isConfirmed) {
            fetch(`/admin/services/${service}` , {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire({
                        title: `Service has been Deleted`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }
                else swal.fire('An error occured, Please try again later')

            })

        }
    })
}

function featureService(serviceId) {
    document.getElementById('featureServiceId').value = serviceId;
}


document.addEventListener('DOMContentLoaded', function () {
    const durationSelect = document.getElementById('featureDuration');
    const customDateContainer = document.getElementById('customDateContainer');

    durationSelect.addEventListener('change', function () {
        if (this.value === 'custom') {
            customDateContainer.style.display = 'block';
        } else {
            customDateContainer.style.display = 'none';
        }
    });

    const confirmBtn = document.getElementById('confirmFeatureBtn');
    const featureForm = document.getElementById('featureServiceForm');

    confirmBtn.addEventListener('click', function () {
        featureForm.submit();
    });

    flatpickr(".flatpickr-datetime", {
        dateFormat: "Y-m-d",
        minDate: "today",
    });
});



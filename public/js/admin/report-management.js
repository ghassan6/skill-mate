// document.addEventListener('DOMContentLoaded', function() {

//     // Filter functionality
//     document.getElementById('applyFilters').addEventListener('click', function() {
//         const status = document.getElementById('reportStatus').value;
//         const type = document.getElementById('reportType').value;
//         const dateRange = document.getElementById('dateRange').value;

//         // Filter rows based on selections
//         document.querySelectorAll('.admin-table tbody tr').forEach(row => {
//             const rowStatus = row.getAttribute('data-status');
//             const rowType = row.getAttribute('data-type');

//             let shouldShow = true;

//             if (status !== 'all' && rowStatus !== status) {
//                 shouldShow = false;
//             }

//             if (type !== 'all' && rowType !== type) {
//                 shouldShow = false;
//             }

//             // Date filtering would require actual date comparison
//             // This is a simplified version

//             row.style.display = shouldShow ? '' : 'none';
//         });
//     });

// });

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


function reportResolve(reportID, action) {
    console.log(reportID);

    let text = action == 'resolve' ? 'Are you sure that the issue is resolved?' : 'Are you sure want to dismiss this issue?'
    let color = action == 'resolve' ? 'rgb(16, 197, 67)' : '#9dbbed'
    Swal.fire({
        title: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${action}`,
        confirmButtonColor: color,
        cancelButtonColor:'rgb(95, 106, 116)',

        }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/reports/${reportID}/resolve`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    action: action
                })
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire({
                        icon: 'success',
                        title: `Report has been ${action}ed`
                    })
                    .then(() => window.location.reload())
                }
                else {
                    swal.fire("An Error ouccured plaese Try again");
                }
            })
        }
        });
}

function deactivateService(slug) {

    console.log(slug)
    Swal.fire({
        title: `Do you want to Deactivate this service?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Deactivate',
        confirmButtonColor: '#dc3545',
        cancelButtonColor:'rgb(95, 106, 116)',

        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            fetch(`/admin/services/${slug}/activate`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(Response => {
                if(Response.ok) {
                    swal.fire(`Service has been Deactivated`)
                    .then(() => window.location.reload())
                }
                else {
                    swal.fire("An Error ouccured plaese Try again");
                }
            })
        }
        });
}

function banUser(user) {
    swal.fire({
        title: `Are you sure you want to ban This user?`,
        text: 'The user will not be able to use the webiste',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ban`,
        confirmButtonColor: '#d33',
    })
    .then(Result => {
        if(Result.isConfirmed) {
            fetch(`/admin/users/${user}/ban`, {
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
                        title: `User Has been Banned`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }

                else swal.fire('An Error ouccured, Please try again later')
            })
        }
    })
}

function showError(message) {
    swal.fire({
        icon: 'error',
        title: message,
    })
}



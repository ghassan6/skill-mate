function deleteContact(contactID) {
    console.log(contactID);

    swal.fire({
        title: `Are you sure you want to Delete This message?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, Delete`,
        confirmButtonColor: 'red',
    })
    .then(Result => {
        if(Result.isConfirmed) {
            fetch(`/contact/${contactID}`, {
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
                        title: `Message has been deleted`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }

                else swal.fire('An Error occurred, Please try again later')
            })
        }
    })
}

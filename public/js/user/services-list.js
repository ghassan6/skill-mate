document.querySelectorAll('.save-service-btn').forEach(button => {
    button.addEventListener('click', async function(e) {
        e.preventDefault(); // Prevent default form submission
        const form = this.closest('form');
        const icon = this.querySelector('i');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }

            const data = await response.json();

            if (data.is_saved) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.color = '#dc3545'; // red
                this.title = 'Remove from saved services';
                this.setAttribute('data-saved', '1');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "The service has been saved",
                    showConfirmButton: false,
                    timer: 1500
                  });
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.style.color = '#6c757d'; // gray
                this.title = 'Save this service';
                this.setAttribute('data-saved', '0');
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "The service has been Unsaved",
                    showConfirmButton: false,
                    timer: 1500
                  });
            }

        } catch (error) {
            console.error('Error:', error);
        }
    });
});

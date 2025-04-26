const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let removeBtn = document.querySelectorAll('.removeBtn');

removeBtn.forEach(btn => {

    btn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('prvented');

        swal.fire({
            title: "Destructive action!",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "I am aware, proceed",
        })
        .then(Response => {
            if(Response.isConfirmed) {
                swal.fire({
                    title: "User Deleted successfully!",
                    icon: 'success',
                })

                .then(() => {
                    let form = btn.closest('form');
                    if(form) form.submit()
                })
            }
        })
    })
})

function toggle_ban(user, status) {

    console.log(user)
    console.log(status)

    let action = status == "" ? 'ban' : 'unban';
    let text = action == 'ban' ? 'The user will not be able to use the webiste' : 'The user will be able to use the website again';
    color = action == 'ban' ? '#d33' : '#1cb807';

    swal.fire({
        title: `Are you sure you want to ${action} This user?`,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${action}`,
        confirmButtonColor: color,
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
                        title: `User Has been ${action}ned`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }

                else swal.fire('An Error ouccured, Please try again later')
            })
        }
    })
}

document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = imagePreview.querySelector('.image-preview__image');
    const previewDefaultText = imagePreview.querySelector('.image-preview__default-text');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";

            reader.addEventListener("load", function() {
                previewImage.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        } else {
            previewDefaultText.style.display = null;
            previewImage.style.display = null;
            previewImage.setAttribute("src", "");
        }
    });

    // Generate random password
    document.getElementById('generatePassword').addEventListener('click', function() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
        let password = '';

        for (let i = 0; i < 12; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }

        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long!');
            return false;
        }

        return true;
    });
});

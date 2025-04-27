const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function confirmDeleteCategory(category) {
    console.log("asd")

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
            fetch(`/admin/categories/${category}` , {
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
                        title: `Category has been Deleted`,
                        icon: 'success'
                    })
                    .then(() => window.location.reload())
                }
                else swal.fire('An error occured, Please try again later')

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

            if (previewDefaultText) previewDefaultText.style.display = "none";
            if (previewImage) previewImage.style.display = "block";

            reader.addEventListener("load", function() {
                previewImage.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        }
    });

    // Slug generation
    let slug = document.getElementById('slug');
    let name = document.getElementById('name');

    name.addEventListener('input' , () => {
        slug.value = name.value.toLowerCase().replace(/\s/g, "-");
    })

});

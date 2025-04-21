document.addEventListener('DOMContentLoaded', function() {
    // Step Navigation
    const steps = document.querySelectorAll('.creation-step');
    const stepNavs = document.querySelectorAll('.step');
    const progressBar = document.querySelector('.progress-bar');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    let currentStep = 1;
    const totalSteps = steps.length;

    // Initialize first step
    showStep(currentStep);

    // Next button click handler
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
                updateProgress();
            }
        });
    });

    // Previous button click handler
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
            updateProgress();
        });
    });

    // Step navigation click handler
    stepNavs.forEach(nav => {
        nav.addEventListener('click', function() {
            const stepToGo = parseInt(this.getAttribute('data-step'));
            if (stepToGo < currentStep) {
                currentStep = stepToGo;
                showStep(currentStep);
                updateProgress();
            }
        });
    });

    // Show specific step
    function showStep(stepNumber) {
        steps.forEach(step => {
            step.classList.remove('active');
            if (parseInt(step.getAttribute('data-step')) === stepNumber) {
                step.classList.add('active');
            }
        });

        stepNavs.forEach(nav => {
            nav.classList.remove('active');
            if (parseInt(nav.getAttribute('data-step')) === stepNumber) {
                nav.classList.add('active');
            }
        });

        // Update review section
        if (stepNumber === 4) {
            updateReviewSection();
        }
    }

    // Update progress bar
    function updateProgress() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progress}%`;
    }

    // Validate current step before proceeding
    function validateStep(step) {
        let isValid = true;

        if (step === 1) {
            let title = document.getElementById('title').value;
            let category = document.getElementById('category_id').value;
            let description = document.getElementById('description').value;

            document.querySelectorAll('.err').forEach(function(error) {
                error.innerHTML = '';
            });

              // Title validation
            if (title.length < 5 || title.length > 50) {
                showError('title', "Title must be between 5 and 50 characters");
                isValid = false;
            }

            // Category validation
            if (!category) {
                showError('category', "Please select a category");
                isValid = false;
            }

            // Description validation
            if (description.length < 30 || description.length > 500) {
                showError('description', "Description must be between 30 and 500 characters");
                isValid = false;
            }
        }

        if(step === 2) {
            let hourly_rate = parseInt(document.getElementById('hourly_rate').value);

            const form = document.getElementById('service-form');

            const uploadedInputs = form.querySelectorAll('input[name="uploaded_images[]"]');

            if (uploadedInputs.length === 0 || uploadedInputs.length > 10) {
                showError('image', 'Please Upload at Least one image and not more than 10')
                isValid = false;
            }


            if (isNaN(hourly_rate) || !Number.isInteger(hourly_rate)) {
                showError('hourlyRate', "Hourly rate must be a valid number.");
                isValid = false;
            }
        }

        if(step == 3) {
            let address = document.getElementById('address').value;
            let city = document.getElementById('city_id').value

            if(!city) {
                showError('city', "Please select a City");
                isValid = false;
            }

            if(address && (address.length < 10 || address.length > 50) ) {
                showError('address', 'Adress must be between 10 and 50 characters ');
                isValid = false;
            }
        }
        return isValid;
    }

     // photo upload validation


    // Update review section with entered values
    function updateReviewSection() {
        document.getElementById('review-title').textContent = document.getElementById('title').value;
        document.getElementById('review-category').textContent = document.getElementById('category_id').options[document.getElementById('category_id').selectedIndex].text;
        document.getElementById('review-description').textContent = document.getElementById('description').value;
        document.getElementById('review-rate').textContent = document.getElementById('hourly_rate').value;
        document.getElementById('review-featured').textContent = document.getElementById('is_featured').checked ? 'Yes' : 'No';
        document.getElementById('review-city').textContent = document.getElementById('city_id').options[document.getElementById('city_id').selectedIndex].text;
        document.getElementById('review-address').textContent = document.getElementById('address').value || 'Not specified';
        // document.getElementById('review-radius').textContent = document.getElementById('service_radius').value;
    }

    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('desc-char-count');

    if (description && charCount) {
        charCount.textContent = description.value.length;
        description.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }


    // to pass the route name u can use this in blade

    //     <script>
    //     window.serviceRoutes = {
    //         upload: "{{ route('services.upload') }}",
    //         store: "{{ route('services.store') }}"  the window make the variable globaly accessable
    //     };
    //  </script>


    // and here (external js file)
    // const uploadUrl = window.serviceRoutes.upload;
    // const storeUrl = window.serviceRoutes.store;

    // so i can pass the route name

    const dropzoneElement = document.getElementById('service-images-dropzone');
    const uploadUrl = dropzoneElement.dataset.storeUrl;


    //Initialize Dropzone for image uploads
    if (typeof Dropzone !== 'undefined') {
        new Dropzone("#service-images-dropzone", {
            url: uploadUrl,
            paramName: "image",
            maxFiles: 10,
            // autoProcessQueue: false, /* its true bu defulat which will fire a post request imediatlly */
            maxFilesize: 5, // MB
            acceptedFiles: "image/*",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            addRemoveLinks: true,
            dictDefaultMessage: "Drag & drop images here or click to browse",
            dictFallbackMessage: "Your browser doesn't support drag'n'drop file uploads.",
            dictFileTooBig: 'File is too big ($filesize MB). Max filesize: $maxFilesize MB.',
            dictInvalidFileType: "You can't upload files of this type.",
            dictResponseError: 'Server responded with $statusCode code.',
            dictCancelUpload: "Cancel upload",
            dictUploadCanceled: "Upload canceled.",
            dictRemoveFile: "Remove file",
            dictMaxFilesExceeded: "You can only upload up to 10 images.",

            success: function(file, resp) {
                if (!resp.success) return;

                // stash the returned path in a hidden input
                const input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = 'uploaded_images[]';
                input.value = resp.file_path;
                file._hiddenInput = input;     // tie it to the file for easy removal
                document.getElementById('service-form').appendChild(input);
              },

              // if the user clicks “Remove file”…
              removedfile: function(file) {
                // remove preview
                if (file.previewElement) {
                  file.previewElement.remove();
                }
                // remove the corresponding hidden input
                if (file._hiddenInput) {
                  file._hiddenInput.remove();
                }

              }
        });
    }


    function showError(field, message) {
        let errorElement = document.getElementById(field + '-error');
        if (errorElement) {
            errorElement.innerHTML = message;
        }
    }
});

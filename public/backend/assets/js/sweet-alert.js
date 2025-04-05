window.soft = {
    showSwal: function (type) {
        switch (type) {
            case 'basic':
                Swal.fire({
                    title: 'Basic example',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary'
                    },
                    buttonsStyling: false
                });
                break;

            case 'success-message':
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'That\'s it!',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary'
                    },
                    buttonsStyling: false
                });
                break;

            case 'warning-message-and-confirmation':
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary me-3',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn bg-gradient-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
                break;

            case 'auto-close':
                Swal.fire({
                    title: "Auto close alert!",
                    text: "I will close in 2 seconds.",
                    timer: 2000,
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary'
                    },
                    buttonsStyling: false
                });
                break;

            case 'custom-html':
                Swal.fire({
                    title: '<strong>HTML <u>example</u></strong>',
                    icon: 'info',
                    html: 'You can use <b>bold text</b>, ' +
                        '<a href="//sweetalert2.github.io">links</a> ' +
                        'and other HTML tags',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary me-3',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                });
                break;

            case 'input-field':
                Swal.fire({
                    title: 'Input email',
                    input: 'email',
                    inputPlaceholder: 'Enter your email address',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                });
                break;

            case 'title-and-text':
                Swal.fire({
                    title: 'Sweet!',
                    text: 'Modal with a custom image.',
                    imageUrl: '/backend/assets/image/team-2.jpg',
                    imageWidth: 400,
                    imageAlt: 'Custom image',
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary'
                    },
                    buttonsStyling: false
                });
                break;

            case 'warning-message-and-cancel':
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: false, // Ensure cancel stays on the right
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary me-3', // Adds margin to separate buttons
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn bg-gradient-primary'
                            },
                            buttonsStyling: false
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'Your imaginary file is safe :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn bg-gradient-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
                break;

            case 'rtl-language':
                Swal.fire({
                    title: 'هل تريد الاستمرار؟',
                    icon: 'question',
                    iconHtml: '؟',
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا',
                    showCancelButton: true,
                    showCloseButton: true,
                    customClass: {
                        confirmButton: 'btn bg-gradient-primary me-3',
                        cancelButton: 'btn bg-gradient-danger'
                    },
                    buttonsStyling: false
                });
                break;
        }
    }
};

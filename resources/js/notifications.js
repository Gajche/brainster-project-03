// resources/js/notifications.js

export function initNotifications() {
    // 1. Configure Toastr defaults
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-bottom-right",
        timeOut: "5000",
    };

    // 2. Look for our "data provider" elements
    const successMessage =
        document.getElementById("flash-success-data")?.dataset.message;
    const errorMessage =
        document.getElementById("flash-error-data")?.dataset.message;
    const validationErrors = document.querySelectorAll(
        ".flash-validation-error",
    );

    // 3. Trigger Toastr based on what we find
    if (successMessage) {
        toastr.success(successMessage);
    }

    if (errorMessage) {
        toastr.error(errorMessage);
    }

    if (validationErrors.length > 0) {
        validationErrors.forEach((error) => {
            toastr.error(error.dataset.message);
        });
    }
}

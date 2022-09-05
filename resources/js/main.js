window.addToast = function(message, color) {
    jQuery('body').append('<div style="z-index: 1060;" class="toast-container end-0 bottom-0 position-absolute"><div data-autohide="true" class="toast align-items-center text-white bg-' + color + ' border-0" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex"><div class="toast-body">' + message + '</div></div></div></div>');
    jQuery('.toast').toast('show');
}
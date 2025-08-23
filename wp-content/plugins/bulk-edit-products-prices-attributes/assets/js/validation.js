jQuery(document).ready(function () {
    const inputFields = [
        document.getElementById('elex_bundle_min_quantity'),
        document.getElementById('elex_bundle_max_quantity'),
        document.getElementById('elex_bundle_default_quantity')
    ];

    const errorMessage        = document.getElementById('error-message');
    const errorMessageDefault = document.getElementById('error-message-default');
    const errorMessageMax     = document.getElementById('error-message-max');
    const errorMessagemin     = document.getElementById('error-message-min');
    // Function to display error message
    function elexShowError(element, message) {
        element.textContent = message;
        element.style.display = 'block';
        element.style.color = 'red';
    }

    // Function to hide error message
    function elexHideError(element) {
        element.textContent = '';
        element.style.display = 'none';
    }

    // Function to reset the border color of the input field
    function elexResetBorderColor(inputField) {
        inputField.style.borderColor = '';
    }

    inputFields.forEach(function (inputField) {
        if (inputField) {
            inputField.addEventListener('input', function () {
                const inputValue = Number(inputField.value);
                const minQuantityValue = Number(document.getElementById('elex_bundle_min_quantity').value);
                const maxQuantityValue = Number(document.getElementById('elex_bundle_max_quantity').value);
                const defQuantityValue = Number(document.getElementById('elex_bundle_default_quantity').value);

                // General validation for negative values
                if (inputValue < 0) {
                    elexShowError(errorMessage, 'Please enter an integer higher than or equal to 0');
                    inputField.style.borderColor = 'red';
                    inputField.value = 0;
                    return;
                } else {
                    elexHideError(errorMessage);
                    elexResetBorderColor(inputField);
                }

                // Minimum quantity field logic
                if (inputField.id === 'elex_bundle_min_quantity') {
                    if (inputValue < 0) {
                        elexShowError(errorMessage, 'Please enter an integer higher than or equal to 0');
                    }
                    const defaultQuantityField = document.getElementById('elex_bundle_default_quantity');
                    defaultQuantityField.value = inputValue > 0 ? inputValue : '';
                }

                // Maximum quantity field logic
                if (inputField.id === 'elex_bundle_max_quantity') {
                    if (inputValue < minQuantityValue) {
                        elexShowError(errorMessageMax, 'Please enter an integer higher than or equal to ' + minQuantityValue);
                        inputField.style.borderColor = 'red';
                    } else {
                        elexHideError(errorMessageMax);
                        elexResetBorderColor(inputField);
                    }
                }

                // Default quantity field logic
                if (inputField.id === 'elex_bundle_default_quantity') {
                    if (inputValue < minQuantityValue) {
                        elexShowError(errorMessageDefault, 'Please enter an integer higher than or equal to ' + minQuantityValue);
                        inputField.style.borderColor = 'red';
                    } else if (inputValue > maxQuantityValue) {
                        elexShowError(errorMessageDefault, 'Please enter an integer lower than or equal to ' + maxQuantityValue);
                        inputField.style.borderColor = 'red';
                    } else {
                        elexHideError(errorMessageDefault);
                        elexResetBorderColor(inputField);
                    }
                }
            });
        }
    });
});

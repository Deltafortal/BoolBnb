// Check Image Url
function isValidUrl(url) {

    return (url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}



// Check Decimal Digits
function checkDecimalMaxDigits(value, maxDigits) {

    const valueString = value.toString();
    const periodPos = valueString.indexOf('.');
    if (periodPos >= 0) return valueString.slice(periodPos + 1).length <= maxDigits;
    return true;// No period found
}


// Validate Field Function

function validateField(fieldName, value) {

    const rules = validationRules[fieldName]
    errors[fieldName] = [];


    // Form Rules
    if (rules.required && !value.trim()) {
        errors[fieldName].push(`Il campo è obbligatorio.`);
    };


    if (rules.maxLength && value.length > rules.maxLength) {
        errors[fieldName].push(`Il campo deve contenere al massimo ${rules.maxLength} caratteri.`);
    };


    if (rules.minLength && parseInt(value) < rules.minLength) {
        errors[fieldName].push(`Inserisci un numero maggiore di ${rules.minLength}.`);
    };


    // TODO Controllo Url


    if (rules.decimalDigits && !checkDecimalMaxDigits(value, rules.decimalDigits)) {
        errors[fieldName].push(`Il campo deve avere al massimo ${rules.decimalDigits} cifre decimali.`);
    };


    if (rules.equal && passwordConfirm.value != password.value) {
        errors[fieldName].push(`Le due password devono essere uguali`);
    }

};


// Update error message

function updateErrorMessages() {
    for (const fieldName in validationRules) {

        const errorContainer = document.getElementById(`${fieldName}-error`);
        const fieldErrors = errors[fieldName];
        if (fieldErrors && fieldErrors.length > 0) {
            errorContainer.innerText = fieldErrors.join(" ");
        } else {
            errorContainer.innerText = "";
        }
    }

    if (page === 'form') {

        // Aggiungi la gestione degli errori dei servizi
        const servicesErrorContainer = document.getElementById('services-error');
        const servicesErrors = errors[servicesCheckboxes];
        if (servicesErrors && servicesErrors.length > 0) {
            servicesErrorContainer.innerText = servicesErrors.join(" ");
        } else {
            servicesErrorContainer.innerText = "";
        }
    }


}

// Check HTML page

function checkPage() {

    const getValidation = document.getElementById('get-validation')

    if (getValidation.dataset.validate == "form") {
        page = 'form'
    } else {
        page = 'register'
    }
    return page
}

// Get the Right elements

function getRightElements() {

    if (page === 'form') {
        targetFields = formFields;
        validationRules = formRules;
    } else {
        targetFields = registerFields;
        validationRules = registerRules;
    }

}

// Check if all fields are validated

function validateAllFields() {
    for (const fieldName in targetFields) {
        const value = targetFields[fieldName].value;
        validateField(fieldName, value);
    }


    validateExceptions();
    updateErrorMessages();
};


//Check for exceptions

function validateExceptions() {

    // Check services
    if (page === "form") {

        servicesCheckboxes = document.querySelectorAll('[name="services[]"]');
        errors[servicesCheckboxes] = [];

        let hasSelectedService = false;
        for (const checkbox of servicesCheckboxes) {
            if (checkbox.checked) {
                hasSelectedService = true;
                break;
            }
        }

        if (!hasSelectedService) {
            errors[servicesCheckboxes].push(`Devi selezionare almeno un servizio.`);
        }
    }

}


// Get the elements
const formFields = {
    title: document.getElementById("title"),
    // description: document.getElementById("description"),
    image: document.getElementById("image"),
    price: document.getElementById("price"),
    rooms: document.getElementById("rooms"),
    beds: document.getElementById("beds"),
    bathrooms: document.getElementById("bathrooms"),
    address: document.getElementById("address"),
};

const registerFields = {
    name: document.getElementById("name"),
    surname: document.getElementById("surname"),
    email: document.getElementById("email"),
    password: document.getElementById("password"),
    passwordConfirm: document.getElementById("passwordConfirm"),
};


// Validation Rules

const formRules = {

    title: {
        required: true,
        maxLength: 255,
    },
    // description: {
    //     maxLength: 255,
    // },
    image: {
        url: true,
    },
    price: {
        required: true,
        decimalDigits: 2,
    },
    rooms: {
        required: true,
        minLength: 1,
    },
    beds: {
        required: true,
        minLength: 1,
    },
    bathrooms: {
        required: true,
        minLength: 1,
    },
    address: {
        required: true,
        maxLength: 255,
    },
    services: {

    }

};

const registerRules = {

    name: {
        maxLength: 255,
    },
    surname: {
        maxLength: 255,
    },
    email: {
        required: true,
    },
    password: {
        required: true,
    },
    passwordConfirm: {
        required: true,
        equal: true,
    }

};

const errors = {};
let page = '';
let validationRules;
let targetFields;
let servicesCheckboxes;
checkPage();
getRightElements();


// Add event listener and call functions

for (const fieldName in targetFields) {

    targetFields[fieldName].addEventListener("input", (e) => {

        validateField(fieldName, e.target.value);
        updateErrorMessages();
    });
}


const validationForm = document.getElementById("validation-form");

validationForm.addEventListener("submit", (event) => {

    validateAllFields();
    const hasErrors = Object.values(errors).some(fieldErrors => fieldErrors.length > 0);
    if (hasErrors) {
        event.preventDefault();
    }
});
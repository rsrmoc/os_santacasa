require('./bootstrap');
const moment = require('moment');

window.API_URL = '/brcondos_adv/json';

window.parseErrorsAPI = (errors, message = null) => {
    if (errors) {
        Object.keys(errors).forEach((keyError) => {
            errors[keyError].forEach((error) => toastr['error'](error));
        });

        return;
    }

    toastr['error'](message);
};

window.formatDate = (date, format = 'L') => {
    return moment(date).format(format);
};
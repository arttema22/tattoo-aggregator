window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
} catch (error) {
    console.log(error);
}

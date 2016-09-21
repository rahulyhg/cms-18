function timeToValue(hour, minute) {
    return hour * 60 + minute;
}

function toDigit2(digit) {
    return ("0" + digit).slice(-2);
}

function getBufferArray() {
    return {
        Monday: [],
        Tuesday: [],
        Wednesday: [],
        Thursday: [],
        Friday: [],
        Saturday: [],
        Sunday: [],
    };
}

var clearArray = function(array) {
    while (array.length > 0) {
        array.pop();
    }
};

var timeslotModule = angular.module('timeslotModule', []);

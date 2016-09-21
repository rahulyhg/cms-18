/**
 * Created by thanhtrung2409 on 4/19/16.
 */
var Template = function() {
    this.settings = [];
    this.active = 0;
    this.id = 0;
    this.timeSlotType = 0;
    this.times = [];
    this.timeInput = {
        hour: 0,
        minute: 0,
    };
    this.timeSpan = {
        fromHour: 8,
        fromMinute: 0,
        toHour: 9,
        toMinute: 0,
        timeSpan: 15,
    };
    this.recurrence = 2;
    this.excludeSaturday = false;
    this.excludeSunday = false;
    this.excludeSpecificDay = false;
    this.excludeDays = [];
    this.specificDay = new Date();
    this.selectAllDaysInWeek = false;
    this.daysInWeek = [{
        key: "Monday",
        value: false
    }, {
        key: "Tuesday",
        value: false
    }, {
        key: "Wednesday",
        value: false
    }, {
        key: "Thursday",
        value: false
    }, {
        key: "Friday",
        value: false
    }, {
        key: "Saturday",
        value: false
    }, {
        key: "Sunday",
        value: false
    }, ];
    this.selectAllDaysInMonth = false;
    this.daysInMonth = [];
    this.errors = {
        specificDay: "",
        timeSlot: "",
        timeSpan: "",
        final: "",
    };
    this.recurrenceOptions = [{
        value: 2,
        key: "Repeat Weekly"
    }, {
        value: 3,
        key: "Repeat Monthly"
    }, ];
};
Template.prototype.checkTimeSlots = function() {
    var result = {
        error: "",
        flag: true,
    };
    var model = this;
    //check existed time slot
    angular.forEach(this.times, function(time) {
        if (parseInt(model.timeInput.hour) == parseInt(time.hour) &&
            parseInt(model.timeInput.minute) == parseInt(time.minute)) {
            this.error = "This time slot is existed.";
            this.flag = false;
            return;
        }
    }, result);
    if (result.flag) this.errors.timeSlot = result.error;
    return result.flag;
};
Template.prototype.addTimeSlot = function() {
    if (this.checkTimeSlots(true)) {
        var copy = $.extend({}, this.timeInput);
        this.times.push(copy);
        this.errors.final = "";
    }
};
Template.prototype.checkSpecificDays = function() {
    var result = {
        specificDay: this.specificDay,
        error: "",
        flag: true,
    };
    angular.forEach(this.excludeDays, function(day) {
        if (day == this.specificDay) {
            this.error = "The day \"" + specificDay + "\" is existed.";
            this.flag = false;
            return;
        }
    }, result);
    if (result.flag) this.errors.specificDay = result.error;
    return result.flag;
};
Template.prototype.addSpecificDay = function() {
    if (this.checkSpecificDays() === true) {
        var sDay = $.datepicker.formatDate("dd/mm/yy", this.specificDay);
        this.excludeDays.push(sDay);
    }
};
Template.prototype.getError = function(key) {
    return this.errors[key];
};
Template.prototype.initDaysOfMonth = function() {
    for (var i = 1; i <= 31; i++) {
        var day = {
            key: i,
            value: false
        };
        this.daysInMonth.push(day);
    }
};
Template.prototype.selectAllDaysInWeekChange = function() {
    angular.forEach(this.daysInWeek, function(day) {
        day.value = this.selectAllDaysInWeek;
    }, this);
};
Template.prototype.selectDayInWeekChange = function() {
    var result = {
        allChecked: true,
    };
    angular.forEach(this.daysInWeek, function(day) {
        if (this.allChecked) {
            if (!day.value)
                this.allChecked = false;
        }
    }, result);
    this.selectAllDaysInWeek = result.allChecked;
};
Template.prototype.selectAllDaysInMonthChange = function() {
    angular.forEach(this.daysInMonth, function(day) {
        day.value = this.selectAllDaysInMonth;
    }, this);
};
Template.prototype.selectDayInMonthChange = function() {
    var result = {
        allChecked: true,
    };
    angular.forEach(this.daysInMonth, function(day) {
        if (this.allChecked) {
            if (!day.value)
                this.allChecked = false;
        }
    }, result);
    this.selectAllDaysInMonth = result.allChecked;
};
Template.prototype.checkSpanTimeInputs = function() {
    var fromVal = this.timeSpan.fromHour * 60 + this.timeSpan.fromMinute;
    var toVal = this.timeSpan.toHour * 60 + this.timeSpan.toMinute;
    if (fromVal >= toVal) {
        this.errors.timeSpan = "Start time must be larger than end time.";
        return false;
    }
    this.errors.timeSpan = "";
    return true;
};
Template.prototype.validate = function() {
    var result = true;
    switch (parseInt(this.timeSlotType)) {
        case 1:
            result = this.checkSpanTimeInputs();
            break;
        case 0:
        default:
            result = true;
    }
    return result;
};
Template.prototype.init = function(data) {
    if (data !== null) {
        angular.forEach(data, function(value, key) {
            if (value !== null) {
                if (value instanceof Array) {
                    if (value.length > 0)
                        this[key] = value;
                } else {
                    this[key] = value;
                }
            }
        }, this);
        this.active = parseInt(this.active);
        this.id = parseInt(this.id);
        this.timeSlotType = parseInt(this.timeSlotType);
        this.recurrence = parseInt(this.recurrence);
        if (!(this.specificDay instanceof Date)) {
            this.specificDay = new Date(this.specificDay);
        }
        if (this.daysInMonth === null || this.daysInMonth.length === 0)
            this.initDaysOfMonth();
        this.selectDayInWeekChange();
        this.selectDayInMonthChange();
    } else
        this.initDaysOfMonth();
};
/**
 * Created by thanhtrung2409 on 4/19/16.
 */
var TimeBuffer = function () {
    this.addressIndex = 0;
    this.hour = null;
    this.minute = null;
};

var TimeBufferInput = function () {
    this.addressIndex = 0;
    this.daysOfWeek = [];
    this.hour = null;
    this.minute = null;
};

var BufferGeneral = function () {
    this.address = [];
    this.inputs = [];
    this.buffers = [];
    this.settings = {
        maxBuffersPerDay: 8,
    };
    this.options = {
        daysOfWeek: ['All', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        hours: Array(24),
        minutes: Array(12),
    };
    this.constants = {
        daysOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    };
    this.errors = [];
};

BufferGeneral.prototype.initHourOptions = function () {
    for (var i = 0; i < this.options.hours.length; i++) {
        this.options.hours[i] = {
            value: i,
            label: toDigit2(i),
        };
    }
};

BufferGeneral.prototype.initMinuteOptions = function () {
    for (var i = 0; i < this.options.minutes.length; i++) {
        var temp = i * 5;
        this.options.minutes[i] = {
            value: temp,
            label: toDigit2(temp),
        };
    }
};

BufferGeneral.prototype.initBuffers = function () {
    this.buffers = getBufferArray();
};

BufferGeneral.prototype.init = function (service,data) {
    //initialize options
    this.initHourOptions();
    this.initMinuteOptions();

    //initialize buffers, inputs and previews
    for (var i = 0; i < 4; i++) {
        var input = new TimeBufferInput();
        input.addressIndex = i;
        input.hour = this.options.hours[0];
        input.minute = this.options.minutes[0];
        this.inputs.push(input);
    }
    this.initBuffers();
    if (data.buffers !== undefined) {
        for (i = 0; i < data.buffers.length; i++) {
            for (var day in data.buffers[i]) {
                for (var j = 0; j < data.buffers[i][day].length; j++) {
                    this.buffers[day].push(data.buffers[i][day][j]);
                }
            }
        }
    }
};

BufferGeneral.prototype.addBufferEvent = function (input) {
    // console.log(input.daysOfWeek.length);
    for (var i = 0; i < input.daysOfWeek.length; i++) {
        var day = input.daysOfWeek[i];
        if (day == 'All') {
            for (var j = 0; j < this.constants.daysOfWeek.length; j++) {
                var tempDay = this.constants.daysOfWeek[j];
                this.addBuffer(tempDay, input);
            }
            break;
        }
        else {
            this.addBuffer(day, input);
        }
    }
    if (this.errors.length > 0) {
        $('#error_buffers').toggle(400, function () {
            setTimeout(function () {
                $('#error_buffers').toggle(400);
            }, 3000);
        });
    }
};

BufferGeneral.prototype.addBuffer = function (day, input) {

    var container = this.buffers[day];
    if (container.length >= this.settings.maxBuffersPerDay) {
        this.errors.push('"' + day + '" is full slots.');
    } else {
        model = this;
        var isExisted;
        angular.forEach(container, function (item) {
            if (!isExisted) {
                if (item.hour == input.hour.value && item.minute == input.minute.value) {
                    model.errors.push('The time slot "' + day + ' ' + input.hour.label + ':' + input.minute.label + '" is existed.');
                    isExisted = true;
                }
            }
        });
        if (!isExisted) {
            var timeslot = new TimeBuffer();
            timeslot.addressIndex = input.addressIndex;
            timeslot.hour = input.hour.value;
            timeslot.minute = input.minute.value;
            container.push(timeslot);
        }
    }
};

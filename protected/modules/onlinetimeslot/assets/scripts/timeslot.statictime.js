/**
 * Created by thanhtrung2409 on 4/19/16.
 */
var StaticTime = function(obj) {
    if (obj !== undefined) {
        this.dayOfWeek = obj.dayOfWeek;
        this.fromHour = parseInt(obj.fromHour);
        this.fromMinute = parseInt(obj.fromMinute);
        this.toHour = parseInt(obj.toHour);
        this.toMinute = parseInt(obj.toMinute);
    } else {
        this.dayOfWeek = 'All';
        this.fromHour = 8;
        this.fromMinute = 0;
        this.toHour = 9;
        this.toMinute = 0;
    }
};
StaticTime.prototype.getFromValue = function() {
    return timeToValue(this.fromHour, this.fromMinute);
};
StaticTime.prototype.getToValue = function() {
    return timeToValue(this.toHour, this.toMinute);
};
StaticTime.prototype.validate = function() {
    return this.getFromValue() < this.getToValue() ? '' : 'From Hour must larger than To Hour';
};
StaticTime.prototype.toString = function() {
    return toDigit2(this.fromHour) + ':' + toDigit2(this.fromMinute) + ' - ' + toDigit2(this.toHour) + ':' + toDigit2(this.toMinute);
};
var StaticTimes = function(data) {
    this.Monday = [];
    this.Tuesday = [];
    this.Wednesday = [];
    this.Thursday = [];
    this.Friday = [];
    this.Saturday = [];
    this.Sunday = [];
    if (data !== undefined) {
        this.init(data);
    }
};
StaticTimes.prototype.merge = function(day) {
    var flag = false;
    var index = 0;
    var len = day.length;
    var result = [];
    for (var i = 0; i < len;) {
        var temp1 = day[i++];
        if (i < len) {
            var temp2 = day[i];
            var mergeObj = this.mergeObjects(temp1, temp2);
            if (mergeObj === null) {
                result.push(temp1);
            } else {
                result.push(mergeObj);
                i++;
                flag = true;
            }
        } else
            result.push(temp1);
    }
    if (flag)
        result = this.merge(result);
    return result;
};
StaticTimes.prototype.mergeObjects = function(obj1, obj2) {
    var fromVal1 = obj1.getFromValue();
    var toVal1 = obj1.getToValue();
    var fromVal2 = obj2.getFromValue();
    var toVal2 = obj2.getToValue();
    var result = jQuery.extend({}, obj1);
    var flag = false;
    var min = obj1;
    var max = obj2;
    if ((fromVal1 < fromVal2) || (fromVal1 == fromVal2 && toVal1 < toVal2)) {
        if (toVal1 >= fromVal2) flag = true;
    } else {
        min = obj2;
        max = obj1;
        if (toVal2 >= fromVal1) flag = true;
    }
    if (flag) {
        result.fromHour = min.fromHour;
        result.fromMinute = min.fromMinute;
        if (toVal1 > toVal2) max = obj1;
        else max = obj2;
        result.toHour = max.toHour;
        result.toMinute = max.toMinute;
        return result;
    } else
        return null;
};
StaticTimes.prototype.add = function(obj) {
    var copy = jQuery.extend({}, obj);
    switch (obj.dayOfWeek) {
        case 'All':
            angular.forEach(this, function(value, key) {
                copy.dayOfWeek = key;
                value.push(copy);
                this[key] = this.merge(value);
                copy = jQuery.extend({}, obj);
            }, this);
            break;
        default:
            this[obj.dayOfWeek].push(copy);
            this[obj.dayOfWeek].merge(this[obj.dayOfWeek]);
    }
};
StaticTimes.prototype.init = function(data) {
    angular.forEach(data, function(item) {
        this[item.dayOfWeek].push(new StaticTime(item));
    }, this);
};
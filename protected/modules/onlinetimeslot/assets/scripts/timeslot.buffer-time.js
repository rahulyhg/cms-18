/**
 * Created by thanhtrung2409 on 4/19/16.
 */
var BufferTime = function(data) {
    this.year = 0;
    this.month = 0;
    this.day = 0;
    this.hour = 0;
    this.minute = 0;

    if (data) {
        this.init(data);
    }
};

BufferTime.prototype.toString = function() {
    return this.year + ':' + this.month + ':' + this.day + ':' + this.hour + ':' + this.minute;
};

BufferTime.prototype.init = function(data) {
    data = data.toString();
    var args = data.split(':');
    if (args.length > 4) {
        this.year = parseInt(args[0]);
        this.month = parseInt(args[1]);
        this.day = parseInt(args[2]);
        this.hour = parseInt(args[3]);
        this.minute = parseInt(args[4]);
    } else if (args.length === 1) {
        this.hour = parseInt(args[0]);
    }
};
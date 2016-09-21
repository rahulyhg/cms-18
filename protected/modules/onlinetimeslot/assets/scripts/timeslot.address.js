/**
 * Created by thanhtrung2409 on 4/19/16.
 */
var Address = function(data) {
    if (data !== undefined) {
        this.init(data);
    } else {
        this.id = 0;
        this.order = 0;
        this.postalCode = 0;
        this.address = '';
        this.shortAddress = '';
        // this.clinicId = 0;
        this.clinicName = '';
        this.staticTimes = null;
    }
};
Address.prototype.init = function(data) {
    this.id = data.id;
    this.order = data.order;
    this.postalCode = data.postalCode;
    this.address = data.address;
    this.shortAddress = data.shortAddress;
    // this.clinicId = data.clinicId;
    this.clinicName = data.clinicName;
    this.staticTimes = new StaticTimes(data.staticTimes);
};
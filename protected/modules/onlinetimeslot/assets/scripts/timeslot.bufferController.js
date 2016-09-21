/**
 * Created by thanhtrung2409 on 4/19/16.
 */
"use strict";
timeslotModule.controller("bufferController", function ($scope, timeslotService) {
    $scope.bufferTime = new BufferTime();
    $scope.doctor_id = $('#doctor_id').val();
    $scope.addresseTemplate = [];
    $scope.bufferGeneral = null;

    $scope.init = function () {
        $scope.bufferGeneral = new BufferGeneral();
        timeslotService.initDoctor({doctor_id: $scope.doctor_id }).then(function (rs) {
            $scope.bufferTime = new BufferTime(rs.bufferTime);
            $scope.addresses = [];
            angular.forEach(rs.addresses, function(item) {
                var address = new Address();
                address.init(item);
                var tempObj = {
                    address: address,
                    // buffer: buffer,
                };
                $scope.addresseTemplate.push(tempObj);
            });
            $scope.bufferGeneral.init(timeslotService,rs);
        });
    };
    $scope.saveBuffer = function() {
        var data = {doctor_id: $scope.doctor_id , bufferTime: $scope.bufferTime.toString()};
        timeslotService.saveBuffer(data).then(function(){
            alert("Saved successfully!");
        });
        $scope.saveTemplate(0);
    };

    $scope.saveTemplate = function(showMsg = 1) {
        var aBuffers = new Array(4);
        for (var day in $scope.bufferGeneral.buffers) {
            for (var i = 0; i < $scope.bufferGeneral.buffers[day].length; i++) {
                var addressIndex = $scope.bufferGeneral.buffers[day][i].addressIndex;
                if (aBuffers[addressIndex] === undefined) {
                    aBuffers[addressIndex] = getBufferArray();
                }
                aBuffers[addressIndex][day].push({
                    addressIndex: addressIndex,
                    hour: $scope.bufferGeneral.buffers[day][i].hour,
                    minute: $scope.bufferGeneral.buffers[day][i].minute,
                });
            }
        }
        var data = {
            doctor_id : $scope.doctor_id,
            template: aBuffers,

        }
        console.log(data);
        timeslotService.saveTemplate(data).then(function(){
            if (showMsg)
                alert("Saved successfully!");
        });
    }

    $scope.init();

    $scope.toDigit2 = function (digit) {
        return ("0" + digit).slice(-2);
    };
});
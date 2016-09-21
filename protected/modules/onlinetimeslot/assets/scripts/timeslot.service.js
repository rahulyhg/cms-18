/**
 * Created by thanhtrung2409 on 4/19/16.
 */
'use strict';

timeslotModule.factory('timeslotService', function ($rootScope, $http, $interval) {
    var baseUrl = $('#baseUrl').val();
    if (baseUrl[baseUrl.length - 1] != '/')
        baseUrl += '/';
    var
        serviceUrl = baseUrl + 'service/',
        urls = {
            initDoctor: serviceUrl + 'initDoctor',
            saveBuffer: serviceUrl + 'saveBuffer',
            saveTemplate: serviceUrl + 'saveTemplate',
        };
    return {
        initDoctor: function (data) {
            var url = urls.initDoctor;
            return $http.post(url,data).then(function (rs) {
                return rs.data;
            });
        },
        saveBuffer: function (data) {
            var url = urls.saveBuffer;
            return $http.post(url, data).success(
                function (data, status, headers, config) {
                    return data;
                }).error(function (data, status, headers, config) {

            });
        },
        saveTemplate: function (data) {
            var url = urls.saveTemplate;
            return $http.post(url, data).success(
                function (data, status, headers, config) {
                    return data;
                }).error(function (data, status, headers, config) {

            });
        }
    };
});
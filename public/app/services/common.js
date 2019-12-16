petMemories.service('commonService', function ($http, $compile, $location, $timeout, $q) {
    var self = this;
    this.baseURL = $('base').attr('href');
    this.commonPopup = $('#listMainSubOfSub');
    this.LIST_API = {
        // Common
        getConfig: {url: 'api/common/getconfig', method: 'POST'},
    };

    this.requestFunction = function (api, params, callback) {
        if (typeof api !== 'undefined') {
            var oAPI = self.LIST_API[api];
            var url = self.baseURL + oAPI.url;
            if (oAPI.method === 'POST') {
                var httpConfig = {
                    method: oAPI.method,
                    data: $.param(params),
                    url: url,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                };
            } else if (oAPI.method === 'GET') {
                if ($.isEmptyObject(params) === false) {
                    url += '?' + $.param(params);
                }
                var httpConfig = {
                    method: oAPI.method,
                    url: url
                };
            }
            $http(httpConfig).then(function successCallback(response) {
                switch (response.data.code) {
                    case 200:
                        callback(response.data);
                        break;
                    case 5002:
                        if (typeof params.skip === 'undefined' || params.skip !== 5002) {
                            self.showAlert(response.data.message);
                        }
                        callback(response.data);
                        break;
                    case 3000:
                        self.showAlert(self.showError(response.data.error));
                        callback(response.data);
                        break;
                    case 5000:
                        self.showAlert('セッションタイムアウトしました。再度ログインしてください。');
                        $timeout(function () {
                            $location.path('/logout');
                        }, 3000);
                        break;
                    default:
                        self.showAlert(response.data.message);
                        callback(response.data);
                        break;
                }
            }, function errorCallback(response) {
                // console.log(response);
            });
        }
    };

    this.showAlert = function (mes) {
        self.commonPopup.find('.modal-title').html('');
        self.commonPopup.find('.content-popup').html(mes);
        self.commonPopup.find('.modal-button').html('');
        self.commonPopup.modal('show');
    };
    this.commonPopupClose = function () {
        var defer = $q.defer();
        self.commonPopup.modal('hide');
        self.commonPopup.on('hidden.bs.modal', function (e) {
            defer.resolve(e);
        });
        return defer.promise;
    };
    this.commonPopupOpen = function ($scope, $config) {
        var btnTemplate = '<button type="button" class="hvr-rectangle-in" ng-click="{function}">{title}</button>';
        var obj = self.commonPopup;
        obj.find('.modal-title').html($config.title);
        obj.find('.content-popup').html($config.content);
        var btn = '';
        angular.forEach($config.button, function (v, k) {
            var temp = btnTemplate.replace('{function}', v._function).replace('{title}', v.title);
            btn += temp;
        });
        obj.find('.modal-button').html(btn);
        $compile(obj)($scope);
        obj.modal({show: true, backdrop: true});
    };

    this.showError = function ($error) {
        var $return = '';
        switch (typeof $error) {
            case 'string':
                $return = $error;
                break;
            case 'object':
                for (var prop in $error) {
                    if ($error.hasOwnProperty(prop)) {
                        $return += $error[prop] + '</br>';
                    }
                }
                break;
            case 'array':
                $.each($error, function ($i, $v) {
                    $return += $v + '</br>';
                });
                break;
            default:
                break;
        }
        return $return;
    };

    this.serializeObject = function (form) {
        var o = {};
        var a = form.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    this.download = function (url, filename) {
        var sFilename = '';
        if (typeof filename !== 'undefined') {
            sFilename = filename;
        } else {
            sFilename = url.substring(url.lastIndexOf("/") + 1).split("?")[0];
        }
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';
        xhr.onload = function () {
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(xhr.response); // xhr.response is a blob
            a.download = sFilename;
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            delete a;
        };
        xhr.open('GET', url);
        xhr.send();
    };
});

petMemories.service('shareProperties', function () {
    var data_search = [];
    var data_search_query = [];
    var data_limit = [];
    var data_item = [];
    var data_not_equal = [];
    var data_search_special = "";
    var index_default = 1;
    var ichiran_search_flag = 0; // 0: call_search, 1: ichiran search

    //temp data search sendto call_search
    var data_ichiran_search = [];
    var data_ichiran_search_query = [];
    var data_ichiran_not_equal = [];

    return {
        getDataSearch: function () {
            return data_search;
        },
        setDataSearch: function (value) {
            data_search = value;
        },
        getDataSearchQuery: function () {
            return data_search_query;
        },
        setDataSearchQuery: function (value) {
            data_search_query = value;
        },
        getDataLimit: function () {
            return data_limit;
        },
        setDataLimit: function (value) {
            data_limit = value;
        },
        getDataItem: function () {
            return data_item;
        },
        setDataItem: function (value) {
            data_item = value;
        },
        getDataNotEqual: function () {
            return data_not_equal;
        },
        setDataNotEqual: function (value) {
            data_not_equal = value;
        },
        resetDataSearch: function () {
            data_search = null;
        },
        resetDataItem: function () {
            data_item = null;
        },
        getIndexDefault: function () {
            return index_default;
        },
        setIndexDefault: function (value) {
            index_default = value;
        },
        getSearchSpecial: function () {
            return data_search_special;
        },
        setSearchSpecial: function (value) {
            data_search_special = value;
        },
        getIchiranSearchFlag: function () {
            return ichiran_search_flag;
        },
        setIchiranSearchFlag: function (value) {
            // value: 0 or 1
            ichiran_search_flag = value;
        },
        getDataIchiranSearch: function () {
            return data_ichiran_search;
        },
        setDataIchiranSearch: function (value) {
            data_ichiran_search = value;
        },
        getDataIchiranSearchQuery: function () {
            return data_ichiran_search_query;
        },
        setDataIchiranSearchQuery: function (value) {
            data_ichiran_search_query = value;
        },
        getDataIchiranNotEqual: function () {
            return data_ichiran_not_equal;
        },
        setDataIchiranNotEqual: function (value) {
            data_ichiran_not_equal = value;
        }
    };
});
angular.module('module.home', []).controller('homeCtrl', [
    '$scope',
    'Requests',
    '$state',
    function(scope, Requests, state) {

        scope.responses = []
        scope.story = {};
        scope.stories = [];

        //getAll();

        function getAll() {
            var payload = {};
            Requests.get('articles/county/nairobi/top', payload, function(data) {
                scope.stories = data.articles;
                console.log(data);
            });
        }

        function getByid(id) {
            var payload = {};
            Requests.get('articles/' + id, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getTopByLocation(location) {
            var payload = {};
            Requests.get('articles/' + location + '/top', payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getLatestByLocation(location, page) {
            var payload = {};
            Requests.get('articles/county' + location + '/page/' + page, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getLatestBycategory(location, categoryname) {
            var payload = {};
            Requests.get('articles/county' + location + '/category/' + categoryname, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

    }
])

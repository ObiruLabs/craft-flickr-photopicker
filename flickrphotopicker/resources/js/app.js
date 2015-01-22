'use strict';

/**
 * Create the module and ensure no conflict with Twig templating.
 */
angular.module('flickrPhotoPicker', [

        'ngResource',
        'ngRepeatReorder'

    ]).config(['$interpolateProvider', function ($interpolateProvider) {

        $interpolateProvider
            .startSymbol('{[{')
            .endSymbol('}]}');

}]);

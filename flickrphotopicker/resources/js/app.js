'use strict';

/**
 * Create the module and ensure no conflict with Twig templating.
 */
angular.module('flickrPhotoPicker', [

        'ngResource'

    ]).config(['$interpolateProvider', function ($interpolateProvider) {

        $interpolateProvider
            .startSymbol('{[{')
            .endSymbol('}]}');

}]);

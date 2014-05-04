'use strict';

(function ($, angular) {

    $(document).ready(function () {
        $('.flickr-photo').livequery(function () {
            angular.bootstrap($(this), ['flickrPhotoPicker']);
        });
    });

})(jQuery, angular);

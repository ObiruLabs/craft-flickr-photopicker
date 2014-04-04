'use strict';

/**
 * Service to retrieve the photos from FlickrPhotoPicker_PhotosController.
 */
angular.module('flickrPhotoPicker')
    .constant('PHOTOS_URL', Craft.getActionUrl('flickrPhotoPicker/photos/all'))
    .factory('Flickr', ['PHOTOS_URL', '$resource', function (PHOTOS_URL, $resource) {

        var photosApi = $resource(PHOTOS_URL, {}, {
            all: {
                interceptor: {
                    response: function(response) {
                        return response.data;
                    }
                }}
        });

        function getPhotos() {
            return photosApi.all().$promise;
        }

        return {
            getPhotos: getPhotos
        };

    }]);

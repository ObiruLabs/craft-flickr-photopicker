'use strict';

/**
 * Service to retrieve the photos from FlickrPhotoPicker_PhotosController.
 */
angular.module('flickrPhotoPicker')
    .constant('PHOTOS_URL', Craft.getActionUrl('flickrPhotoPicker/photos/all'))
    .constant('PHOTOSET_URL', Craft.getActionUrl('flickrPhotoPicker/photos/allPhotoSets'))
    .constant('PHOTOSETPHOTOS_URL', Craft.getActionUrl('flickrPhotoPicker/photos/photoSet'))
    .factory('Flickr', ['PHOTOS_URL', 'PHOTOSET_URL', 'PHOTOSETPHOTOS_URL', '$resource',
        function (PHOTOS_URL, PHOTOSET_URL, PHOTOSETPHOTOS_URL, $resource) {

            var interceptor = {
                    interceptor: {
                        response: function (response) {
                            return response.data;
                        }
                    }
                },
                photosApi = $resource(PHOTOS_URL, {}, {
                    all: interceptor
                }),
                photoSetsApi = $resource(PHOTOSET_URL, {}, {
                    all: interceptor
                }),
                photoSetPhotosApi = $resource(PHOTOSETPHOTOS_URL, {}, {
                    all: interceptor
                });

            function getPhotos() {
                return photosApi.all().$promise;
            }

            function getPhotoSets() {
                return photoSetsApi.all().$promise;
            }

            function getPhotoSetPhotos(id) {
                return photoSetPhotosApi.all({ id: id }).$promise;
            }

            return {
                getPhotos: getPhotos,
                getPhotoSets: getPhotoSets,
                getPhotoSetPhotos: getPhotoSetPhotos
            };

        }]);

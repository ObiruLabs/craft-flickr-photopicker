'use strict';

/**
 * Controller to enable picking and removing photos from the form.
 */
angular.module('flickrPhotoPicker')
    .controller('flickrPhotoPickerCtrl', ['$scope', 'Flickr', function ($scope, Flickr) {

        $scope.form = {
            name: null,
            rawSelected: [],
            selectedInitialized: false,
            selected: [],
            selectedText: 'Loading your photos',
            photosLoaded: false,
            photoSets: [],
            photosetid: '!!'
        };

        $scope.toggleSelected = function (id) {
            var photo = _.find($scope.form.photos, { id: id });
            photo.checked = !photo.checked;
        };

        $scope.setSelected = function (selected) {
            var photos = _($scope.form.photos);

            if ($scope.form.photosetid !== '!!') {
                photos = _($scope.form.photos).filter({ photosetid: +$scope.form.photosetid })
            }

            photos.forEach(function (photo) {
                photo.checked = selected;
            });
        };

        $scope.removeAllSelected = function () {
            _.forEach($scope.form.selected, function (selected) {
                $scope.toggleSelected(selected.id);
            });
        };

        $scope.$watch('form', function () {
            if (_.isObject($scope.form.photos)) {
                $scope.form.selected = _.filter($scope.form.photos, 'checked');

                if (!$scope.form.selectedInitialized && !_.isEmpty($scope.form.rawSelected)) {
                    initSelected();
                }
            }
        }, true);

        /**
         * Selects the photos that have been already selected
         * when the form was previously saved.
         */
        function initSelected() {
            _($scope.form.rawSelected).uniq().forEach(function (photoId) {
                var photo = _.find($scope.form.photos, { id: photoId });
                photo.checked = true;
                $scope.form.selected.push(photo);
            });
            $scope.form.selectedInitialized = true;
        }

        Flickr.getPhotos().then(function (photos) {
            $scope.form.photos = _.values(photos.photos);
            $scope.form.selectedText = 'Select photos below';
            $scope.form.photosLoaded = true;

            $scope.form.photoSets = _($scope.form.photos)
                .map(function (photo) {
                    return {
                        id: photo.photosetid,
                        name: photo.photosetname
                    };
                })
                .uniq(false, 'id')
                .value();
        });

    }]);

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
            selectedText: 'Loading your photo sets',
            photoSetsLoaded: false,
            photosLoaded: true,
            photoSets: [],
            photos: {},
            photosetid: null
        };

        $scope.toggleSelected = function (id) {
            var photo = _.find($scope.form.photos, { id: id });
            photo.checked = !photo.checked;

            if (photo.checked) {
                $scope.form.selected.push(photo);
            } else {
                removeSelected(id);
            }
        };

        $scope.removeSelected = function (id) {
            _(removeSelected(id))
                .map('id')
                .forEach(function (id) {
                    var photo = _.find($scope.form.photos, { id: id });
                    if (photo) {
                        photo.checked = false;
                    }
                });
        };

        $scope.setSelected = function (selected) {
            _.forEach($scope.form.photos, function (photo) {
                var selectedPhoto = _.find($scope.form.selected, { id: photo.id });
                photo.checked = selected;

                if (selected && !selectedPhoto) {
                    $scope.form.selected.push(photo);
                } else if (!selected && selectedPhoto) {
                    removeSelected(selectedPhoto.id);
                }
            });
        };

        $scope.removeAllSelected = function () {
            var ids = _.map($scope.form.selected, 'id');

            _.forEach(ids, function (id) {
                var photo = _.find($scope.form.photos, { id: id });
                if (photo) {
                    photo.checked = false;
                }
            });

            $scope.form.selected.length = 0;
        };

        $scope.changePhotoSet = function () {
            $scope.form.photosLoaded = false;
            Flickr.getPhotoSetPhotos($scope.form.photosetid).then(function (result) {
                $scope.form.photos = result.photos;
                $scope.form.photosLoaded = true;

                _.forEach($scope.form.photos, function (photo) {
                    photo.photosetid = $scope.form.photosetid;
                    photo.photoset = _.find($scope.form.photoSets, { id: $scope.form.photosetid }).title._content;
                });

                selectLoaded();
            });
        };

        /**
         * Check the photos that have been selected.
         */
        function selectLoaded() {
            _.forEach($scope.form.selected, function (selected) {
                var photo = _.find($scope.form.photos, { id: selected.id });
                if (photo) {
                    photo.checked = true;
                }
            });
        }

        function removeSelected(id) {
            return _.remove($scope.form.selected, function (photo) {
                return photo.id === id;
            });
        }

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

        $scope.$watch('form.rawSelected', function () {
            if (!_.isEmpty($scope.form.rawSelected)) {
                $scope.form.selected = _.map($scope.form.rawSelected, angular.fromJson);
            }
        });

        Flickr.getPhotoSets().then(function (result) {
            $scope.form.photoSetsLoaded = true;
            $scope.form.photoSets = result.photosets;
        });
    }]);

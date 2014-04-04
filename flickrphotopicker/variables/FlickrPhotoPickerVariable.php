<?php
namespace Craft;

/**
 * Class that exposes functions to retrieve the photo urls from the saved fields.
 *
 * @package Craft
 */
class FlickrPhotoPickerVariable
{
    /**
     * Retrieve photos with the photo set name attached to each photo.
     *
     * @param $ids
     * @return array
     */
    public function getWithPhotoSetDetail($ids)
    {
        $photos = craft()->flickrPhotoPicker_photoList->getAllPhotos();
        return $this->parsePhotos($ids, $photos);
    }

    /**
     * Retrieve the photo details for the given photo ids.
     *
     * @param $ids
     * @return array
     */
    public function getPhotoDetails($ids)
    {
        $photos = craft()->flickrPhotoPicker_photoList->getAllPhotosWithoutPhotoSet();
        return $this->parsePhotos($ids, $photos);
    }

    /**
     * Match photos to the ids and add urls to them.
     *
     * @param $ids
     * @param $photos
     * @return array
     */
    public function parsePhotos($ids, $photos)
    {
        $details = array();

        for($i = 0; $i < count($ids); ++$i) {
            $photo = $photos[$ids[$i]];
            $photo['links'] = craft()->flickrPhotoPicker_photoList->getPhotoUrls($photo);
            $details[] = $photo;
        }

        return $details;
    }
}

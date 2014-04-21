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
     * Retrieve the photo details for the given photos that were saved.
     *
     * @param $rawPhotos
     * @return array
     */
    public function getPhotoDetails($rawPhotos)
    {
        $details = array();

        for($i = 0; $i < count($rawPhotos); ++$i) {
            $photo = json_decode($rawPhotos[$i]);
            $photo->links = craft()->flickrPhotoPicker_photoList->getPhotoUrls($photo);
            $details[] = $photo;
        }

        return $details;
    }
}

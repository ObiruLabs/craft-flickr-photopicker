<?php
namespace Craft;

/**
 * Exposes the list of photos to be used in the front end
 * when picking photos.
 *
 * @package Craft
 */
class FlickrPhotoPicker_PhotosController extends BaseController
{
    public function actionAll()
    {
        $photos = craft()->flickrPhotoPicker_photoList->getAllPhotos();

        $this->returnJson(array('photos' => $photos));
    }
}

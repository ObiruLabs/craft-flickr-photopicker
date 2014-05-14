<?php
namespace Craft;

/**
 * Class that fetches photos from the Flickr API.
 *
 * @package Craft
 */
class FlickrPhotoPicker_PhotoListService extends BaseApplicationComponent
{
    /**
     * Retrieves all the photos with photo set detail included for each photo.
     *
     * @return array
     */
    public function getAllPhotos()
    {
        $settings = craft()->plugins->getPlugin('flickrPhotoPicker')->getSettings();
        $apiKey = $settings['apiKey'];
        $userId = $settings['userId'];
        $allPhotos = array();

        $photosets = $this->getFromUrl($this->photoSetsUrl($apiKey, $userId), 'photosets', 'photoset');

        foreach ($photosets as $photosetId => $photosetDetails) {
            $photos = $this->getFromUrl($this->photosForPhotoSetUrl($apiKey, $photosetId), 'photoset', 'photo');
            foreach ($photos as $photoId => $photoDetails) {
                $photoDetails['photosetid'] = $photosetId;
                $photoDetails['photosetname'] = $photosetDetails['title']['_content'];
                $allPhotos[$photoId] = $photoDetails;
            }
        }

        return $allPhotos;
    }

    /**
     * Retrieves all photos without photo set detail. This takes fewer API calls since
     * this uses a single endpoint to retrieve the photos instead of going through
     * the photo set resource.
     *
     * @return array
     */
    public function getAllPhotosWithoutPhotoSet()
    {
        $settings = craft()->plugins->getPlugin('flickrPhotoPicker')->getSettings();
        $apiKey = $settings['apiKey'];
        $userId = $settings['userId'];

        return $this->getFromUrl($this->publicPhotosUrl($apiKey, $userId), 'photos', 'photo');
    }

    /**
     * Retrieves the all of the photo sets.
     *
     * @return array
     */
    public function getAllPhotoSets()
    {
        $settings = craft()->plugins->getPlugin('flickrPhotoPicker')->getSettings();
        $apiKey = $settings['apiKey'];
        $userId = $settings['userId'];

        return $this->getFromUrl($this->photoSetsUrl($apiKey, $userId), 'photosets', 'photoset');
    }

    /**
     * Retrieves photos for the given photo set.
     */
    public function getPhotoSetPhotos($photoSetId)
    {
        $settings = craft()->plugins->getPlugin('flickrPhotoPicker')->getSettings();
        $apiKey = $settings['apiKey'];
        $userId = $settings['userId'];
        $allPhotos = array();

        $photos = $this->getFromUrl($this->photosForPhotoSetUrl($apiKey, $photoSetId), 'photoset', 'photo');
        foreach ($photos as $photoId => $photoDetails) {
            $allPhotos[$photoId] = $photoDetails;
        }

        return $allPhotos;
    }

    /**
     * Retrieve all items from paged resource.
     *
     * @param $url
     * @param $responseKey
     * @param $itemKey
     * @return array
     */
    public function getFromUrl($url, $responseKey, $itemKey)
    {
        $maxPage = 2;
        $page = 1;
        $perPage = 500;
        $allItems = array();

        while ($page <= $maxPage) {
            $contents = file_get_contents($url.'&page='.$page.'&per_page='.$perPage);
            $json = json_decode($contents);
            $response = $json->$responseKey;

            $items = $response->$itemKey;
            $maxPage = $response->pages;
            $page++;

            for($i = 0; $i < count($items); ++$i) {
                $allItems[$items[$i]->id] = $items[$i];
            }
        }

        return $allItems;
    }

    public function publicPhotosUrl($apiKey, $userId)
    {
        $url = $this->apiUrl('flickr.people.getPublicPhotos', $apiKey);
        $url .= '&user_id='.$userId;
        return $url;
    }

    public function photoSetsUrl($apiKey, $userId)
    {
        $url = $this->apiUrl('flickr.photosets.getList', $apiKey);
        $url .= '&user_id='.$userId;
        return $url;
    }

    public function photosForPhotoSetUrl($apiKey, $photoSetId)
    {
        $url = $this->apiUrl('flickr.photosets.getPhotos', $apiKey);
        $url .= '&photoset_id='.$photoSetId;
        return $url;
    }

    /**
     * Creates the base URL for the Flickr API.
     *
     * @param $method
     * @param $apiKey
     * @return string
     */
    public function apiUrl($method, $apiKey)
    {
        $url = 'https://api.flickr.com/services/rest/?method='.$method;
        $url .= '&api_key='.$apiKey;
        $url .= '&format=json';
        $url .= '&nojsoncallback=1';
        return $url;
    }

    /**
     * Creates URLs to all sizes for the given photo.
     *
     * @param $photo
     * @return array
     */
    public function getPhotoUrls($photo)
    {
        $sizes = array('s', 'q', 't', 'm', 'n', 'c', 'b', 'o');
        $link = "http://farm{$photo->farm}.staticflickr.com/{$photo->server}/{$photo->id}_{$photo->secret}";
        $links = array();

        for($i = 0; $i < count($sizes); ++$i) {
            $links[$sizes[$i]] = $link.'_'.$sizes[$i].'.jpg';
        }

        return $links;
    }
}

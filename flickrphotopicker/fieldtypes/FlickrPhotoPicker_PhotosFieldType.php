<?php
namespace Craft;

/**
 * Defines a custom Flickr field type.
 *
 * @package Craft
 */
class FlickrPhotoPicker_PhotosFieldType extends BaseFieldType
{
    public function getName()
    {
        return Craft::t('Flickr Photos');
    }

    public function defineContentAttribute()
    {
        return AttributeType::Mixed;
    }

    public function getInputHtml($name, $value)
    {
        return craft()->templates->render('flickrphotopicker/photos/input', array(
            'name'  => $name,
            'values' => $value
        ));
    }
}

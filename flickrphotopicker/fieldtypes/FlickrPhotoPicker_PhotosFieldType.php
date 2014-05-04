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

    protected function defineSettings()
    {
        return array(
            'limit' => array(AttributeType::Number)
        );
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('flickrphotopicker/photos/settings', array(
            'settings' => $this->getSettings()
        ));
    }

    public function getInputHtml($name, $value)
    {
        return craft()->templates->render('flickrphotopicker/photos/input', array(
            'settings' => $this->getSettings(),
            'name'  => $name,
            'values' => $value
        ));
    }
}

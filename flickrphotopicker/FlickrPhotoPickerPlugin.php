<?php
namespace Craft;

class FlickrPhotoPickerPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Flickr Photo Picker');
    }

    function getVersion()
    {
        return '1.1.1';
    }

    function getDeveloper()
    {
        return 'Obiru Labs';
    }

    function getDeveloperUrl()
    {
        return 'http://obirulabs.com';
    }

    protected function defineSettings()
    {
        return array(
            'apiKey' => array(AttributeType::String, 'required' => true, 'label' => 'API Key', 'default' => Craft::t('Your API key')),
            'userId' => array(AttributeType::String, 'required' => true, 'label' => 'API Key', 'default' => Craft::t('Your User Id'))
        );
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('flickrphotopicker/settings', array(
            'settings' => $this->getSettings()
        ));
    }
}

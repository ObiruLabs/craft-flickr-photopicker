# Craft Flickr PhotoPicker
This is a [Craft CMS](http://buildwithcraft.com/) plugin that provides a custom field to pick Flickr photos.

![plugin demo](https://github.com/ObiruLabs/craft-flickr-photopicker/raw/master/demo/FlickrPickerDemo.gif)

## Installation
To install FlickrPhotoPicker:

* Copy the flickrphotopicker/ folder to your craft/plugins/ folder.
* Go to Settings > Plugins from your Craft control panel and install the Flickr Photo Picker plugin.
* Configure the plugin settings with your Flickr API key and a User ID.
* Create a new ` Flickr Photos ` field.

## Template Usage
Get the Flickr Photos:

```
{% set photos = craft.flickrPhotoPicker.getPhotoDetails(entry.flickrPhotos) %}
```

Quickly render the medium size links:

```
{% for photo in photos %}
    %img{ src: "{{ photo.links.m | raw }}" }
{% endfor %}
```

## Template Variables

You also have access to several other pieces of information about each photo. These are the same properties that are returned by the Flickr API.

```
// Get the link and get a single photo
{% set photos = craft.flickrPhotoPicker.getPhotoDetails(entry.flickrPhotos) %}
{% set photo = photos[0] %}

{{ photo.id }}
{{ photo.owner }}
{{ photo.secret }}
{{ photo.server }}
{{ photo.farm }}
{{ photo.title }}
{{ photo.ispublic }}
{{ photo.isfriend }}
{{ photo.isfamily }}

// URL links to the photos
{{ photo.links.s | raw }}
{{ photo.links.q | raw }}
{{ photo.links.t | raw }}
{{ photo.links.m | raw }}
{{ photo.links.n | raw }}
{{ photo.links.c | raw }}
{{ photo.links.b | raw }}
{{ photo.links.o | raw }}
```

Example photo object when JSON encoded:

```
// Get the link and get a single photo
{% set photos = craft.flickrPhotoPicker.getPhotoDetails(entry.flickrPhotos) %}
{{ photos[0] | json_encode() }}

{
   "id":"8980505187",
   "owner":"44494372@N05",
   "secret":"74eb03d8b4",
   "server":"2840",
   "farm":3,
   "title":"Apollo 11, 1969",
   "ispublic":1,
   "isfriend":0,
   "isfamily":0,
   "links":{
      "s":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_s.jpg",
      "q":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_q.jpg",
      "t":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_t.jpg",
      "m":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_m.jpg",
      "n":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_n.jpg",
      "c":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_c.jpg",
      "b":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_b.jpg",
      "o":"http:\/\/farm3.staticflickr.com\/2840\/8980505187_74eb03d8b4_o.jpg"
   }
}
```

## Roadmap
### In Progress
* Lazy load and cache photoset images on the admin panel.
* Smarter fetching of images when loading details.
* Tutorial on this plugin.

### Ideas for Features
* Ability to configure different user ids per field.
* Ability to restrict a field to a certain photo set.
* Restrict to selecting a single photo.

## Change Log
### 0.0.1 (4 April 2014)
* Custom Flickr Picker Field
* Supports a single user id

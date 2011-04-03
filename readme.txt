=== Gallery Just Better ===
Contributors: stefsoton
Donate link: http://www.stefaniamarchisio.com/donations/
Tags: gallery, mosaic, image, images, picture, pictures, photo, photos, photograph, photographs, photoblog, photoblogs, thumbnail, thumbnails, link, links, linkable, clickable, framed, shortcode
Requires at least: 2.5
Tested up to: 3.1
Stable tag: 0.2

The look & feel of the native wp [gallery] with added features: non-linkable images or linkable to external URLs; linked page viewable in a new window.

== Description ==

It's a tiny bit more flexible than wp native gallery. It finally allows non-linked images and images linking to external URLs. It also allows linked images/pages opening in a new page.

== Installation ==

1. From Plugins of your wordpress administration, select "Add new", search for "gallery just better" into the search text-box then click on 'Install Now' (below the plugin name) when prompted OR download this plugin from [wordpress repository](http://wordpress.org/extend/plugins/gallery-just-better/) or from [Stef's blog](http://www.stefaniamarchisio.com/wp-content/uploads/2011/04/gallery-just-better-0.2.zip), unzip it (a directory with 2 files will be extracted) and upload it to the '/wp-content/plugins/' directory of your wordpress

3. Activate the plugin from the Plugins menu in your WordPress administration

4. Use it! (see Usage in Other Notes)

== Frequently Asked Questions ==

= Why would I need/want it?

= it can either be a replacement to wp native gallery if you need the added features described above or a simple no frills/no nonsenses gallery. More, much more to come.

== Screenshots ==

1. Attributes explained

== Changelog ==

= 0.2 =

* Second release. Based on wp 3.1 native wp gallery

= 0.1 =

* First release. Based on wp 3.0.4 native wp gallery

== Upgrade Notice ==

= 0.2 =

* Second release. Code changed according to amendments made to 3.1 native wp gallery
^ Adjustments to readme.txt file

= 0.1 =

* First release. Based on wp 3.0.4 native wp gallery

== Other Notes ==

== Usage ==

As it is a shortcode:

^ From the admin wp page->Posts/Pages->Add New or Edit, select HTML in the entry form and enter [galleryjb]
^ Attach one or more images to the post or define a PostID attribute which has attachements i.e. [galleryjb postid=123]
^ There are no mandatory attributes: it will show the attached images as a gallery if attachments are present in the current post or in postid, if postid as attribute is defined.
^ Optional attributes are all those you can see in wp 3.0.4 or 3.1 of native gallery plus:
^^ link: besides "file" (= images are linked to imagefile) and the default null string (= images are linked to the attachment's permalink) already present in wp gallery, there is now "null" (images are not clickable/linkable) and "url" (images are linked to external URLs defined in Description).
Please note that if you choose link="url", the Description textbox in Media library needs to contain a url (http(s)..etc) and not a textual description. On the other hand, Description is not used by wp native [ gallery ] in any case.
^^ target: boolean. if true linked objects open in a new/the same window, if false (default) in the same window
^^ author: true (default) or false whether you allow this plugin's author footer to be displayed or not (please, say yes).

== Examples ==

[galleryjb link="null"] ==> Images are not clickable
[galleryjb target="true"] ==> Images link to the attachment's permalink and open up in a new page
[galleryjb link="url"target="true"] ==> Images link to external URL defined in the Description textbox (in Media library). These URLs will open up in a new page.
[galleryjb link="url"] ==> Images link to external urls defined in the Description textbox (in Media library). They will open up in the same page (as default)

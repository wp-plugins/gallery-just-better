=== Gallery Just Better ===
Contributors: stefsoton
Donate link: http://www.stefaniamarchisio.com/donations/
Tags: gallery, image, images, picture, pictures, photo, photos, photograph, photographs, photoblog, photoblogs, thimbnail, thumbnails, link, links, linkable, clickable, framed, shortcode
Requires at least: 2.5
Tested up to: 3.0.4
Stable tag: 0.1

The look & feel of the native wordpress [gallery] with a few new features: non-linked images, images linkable to extrenal URLs and linked objects displayable on a new tab/window.

== Description ==

It's a tiny bit more flexible wp native gallery. It finally allows non-linked images and images linking to external URLs and linked object opening in a new page.

== Installation ==

1. From Plugins->Installed of your wordpress administration, select "Add new", search for "gallery just better" into the search text-box then click on 'Install' (on the right) when prompted with this plugin

                                    OR

2. Download this plugin from [wordpress repository](http://wordpress.org/extend/plugins/gallery-just-better/) or from [Stef's blog](http://www.stefaniamarchisio.com/wp-content/uploads/2011/01/gallery-just-better-0.1.zip), unzip it (a directory with 2 files will be extracted) and upload it to the '/wp-content/plugins/' directory of your wordpress

3. Activate the plugin through the Plugins->Installed menu in your WordPress administration

4. Enter it (see Usage in Other Notes)

== Frequently Asked Questions ==

= Why the heck would I need/want it?

= it can be either a replacement for wp native gallery if you need the added features described above or a simple no frills/no nonsenses gallery. More, much more to come.

== Screenshots ==

1. Attributes explained

== Changelog ==

= 0.1 =

* First release. Based on wp 3.0.4 native gallery
== Upgrade Notice ==

= 0.1 =

* First release. Based on wp 3.0.4 native gallery

== Usage ==

As a shortcode:

* Your admin wp page->Posts/Pages->Add New or Edit, select HTML in the entry form;
* enter [galleryjb]; 
No mandatory attributes. It shows the attached images if attachments are present in the current post or in postid if defined.

Optional attributes are all those of wp 3.0.4 native gallery plus:

* link: besides "file" (links images to imagefile), there is now "null" (images are not clickable/linkable) and "url" (links to external url defined in Description). Default is '' (null string) (images link to the attachment's permalink)
* target: boolean. if true linked objects open in a new/the same window, if false (default) in the same window
* author: true (default) or false whether you allow this plugin's author footer to be displayed or not (please, say yes).

Examples: 
[galleryjb link="url" target="true"] //images link to external url defined in Description textbox (in Media library). These pages open in a new page.
[galleryjb link="null"] // images are not clickable
[galleryjb target="true"] // images link to the attachment's permalink and open up in a new page.

Note: Please note that if you choose link="url", the Description textbox in Media library needs to contain a url (http(s)..etc) and not a description. On the other hand, Description would not be used anyhow by [gallery] plugin.

== The Future ==
* Bespoken table to store images so that these are independent from posts (no need to be attached to posts).

== Interaction ==
* Would you like to see a new feature in this plugin? Please write me here: mywizardwebs@gmail.com;
* Would you like to see a broken/orphan plugin working again? Write me anyhow, I might (hey, MIGHT not will/shall) find the time to give it a look.
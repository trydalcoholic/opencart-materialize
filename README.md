# Materialize template
Most of the topics for OpenCart (OCStore) used Bootstrap as the main framework.
In this theme used the same [Materialize](https://github.com/Dogfalo/materialize) CSS framework.
## How it looks like
* [Main page](https://materialize.myefforts.ru/)
* [Card product](https://materialize.myefforts.ru/smartphones/iphone-smart/iphone-7-plus-red-special-edition-256gb)
* [Category page](https://materialize.myefforts.ru/smartphones/)
## Differences from standard features OpenCart
### Administration
* Added button "Save and Stay"
* Added "Custom Tabs" in product page
* Added the ability to make an inactive basket button
* Disable image compression
### Store front
* No Bootstrap, only Materialize
* Added "Call back me"
* Quite a lot of small changes that make up the overall distinctive site, it's easier to compare product cards 
[Materialize Theme](https://materialize.myefforts.ru/smartphones/iphone-smart/iphone-7-plus-red-special-edition-256gb) and 
[Default Theme](https://demo.opencart.com/index.php?route=product/product&product_id=40) :)
* Added structured data (Schema.org). Example: 
[Product card](https://search.google.com/structured-data/testing-tool/u/0/#url=https%3A%2F%2Fmaterialize.myefforts.ru%2Fsmartphones%2Fiphone-smart%2Fiphone-7-plus-red-special-edition-256gb)
* The site is quickly loaded. Check the various pages of the site (the site uses the analytics system Yandex.Metrica, which adversely affects the evaluation):
  - [Google PageSpeed](https://developers.google.com/speed/pagespeed/)
  - [Pingdom Website Speed Test](https://tools.pingdom.com/)
  - [GTmetrix](https://gtmetrix.com/)
* Check out some other site tests:
  - Markup Validation Service: [main page](https://validator.w3.org/nu/?doc=https%3A%2F%2Fmaterialize.myefforts.ru%2F) and 
  [product card](https://validator.w3.org/nu/?doc=https%3A%2F%2Fmaterialize.myefforts.ru%2Fsmartphones%2Fiphone-smart%2Fiphone-7-plus-red-special-edition-256gb)
## Installation and removal
For a secure installation, you use the local theme folder and 2 installer files (OCMod.xml and SQL), 
which allows you to rollback changes in the event of conflict situations. 
In order to avoid unforeseen errors, make sure you back up the site.
### Install
1.  Copy the materialize folder to the folder at: /catalog/view/theme;
2.  Import the file into the materialize_theme_for_ocstore.ocmod.sql in phpMyAdmin;
3.  In the Admin panel open Extensions -> Extension Installer -> Upload File and select materialize_theme_for_ocstore.ocmod.xml;
4.  Open Extensions -> Modifications;
5.  Click on the refresh button;
6.  Open Extensions -> Extensions -> Choose the extension type -> Choose -> Themes;
7.  Default Store Theme -> Edit;
8.  Theme Directory -> Materialize.
### Uninstalling
1.  Extensions -> Modifications: select Materialize Theme For OCStore and click on the delete button. 
On the same page, click the refresh button;
2.  Import the file into the delete_materialize_theme_for_ocstore.ocmod.sql in phpMyAdmin;
3.  Open Extensions -> Extensions -> Choose the extension type -> Choose -> Themes;
4.  Default Store Theme -> Edit;
5.  Theme Directory -> Default;
6.  Remove the materialize folder from: /catalog/view/theme.
## Recommendations for setting theme images
* Default Items Per Page: 18
* List Description Limit: ~400
* Category Image Size (W x H): 100x100
* Product Image Thumb Size (W x H): 250x250
* Product Image Popup Size (W x H): 1200x1200 or up to 2000x2000
* Product Image List Size (W x H): 250x250
* Additional Product Image Size (W x H): 100x100
* Related Product Image Size (W x H): 250x250
* Compare Image Size (W x H): 90x90
* Wish List Image Size (W x H): 47x47
* Cart Image Size (W x H): 47x47
* Store Image Size (W x H): By the size of your logo
## Technologies used
* [jQuery](https://github.com/jquery/jquery)
* [Materialize](https://github.com/Dogfalo/materialize)
* [Material Design Icons](https://github.com/google/material-design-icons)
* [Slick](https://github.com/kenwheeler/slick)
* [PhotoSwipe](https://github.com/dimsemenov/PhotoSwipe)
* [Lazysizes](https://github.com/aFarkas/lazysizes)

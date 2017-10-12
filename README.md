# Materialize template for OpenCart 2.3.x
![OpenCart Materialize Logo](https://materialize.myefforts.ru/image/OpenCart-Materialize-logo.jpg)
Most of the topics for OpenCart (OCStore) used Bootstrap as the main framework.
In this theme used the same [Materialize](https://github.com/Dogfalo/materialize) CSS framework.
## How it looks like
| **Main page** | **Card product** | **Category page** |
| --- | --- | --- |
| [Main page](https://materialize.myefforts.ru/) | [Card product](https://materialize.myefforts.ru/smartphones/iphone-smart/iphone-7-plus-red-special-edition-256gb)  | [Category page](https://materialize.myefforts.ru/smartphones/) |

***
![A good example of a working site](https://materialize.myefforts.ru/image/opencart-materialize-template-github.gif)
***

## Differences from standard features OpenCart
The main difference of the template is the use of the [Materialize framework](https://github.com/Dogfalo/materialize), based on the principles of material design from Google. All the power of the framework has made it possible to achieve a beautiful, intuitive and adaptive design. Provided stunning view and responsiveness of the site both on desktops and on mobile devices. A principled and uncompromising approach with regard to download speed of the site allowed achieving actual fast download speeds and high scores on the sites of the testers.

The template is not limited to moving the work of OpenCart to the Materialize framework. A huge amount of standard functionality was processed. Integrated many unique technical solutions, many useful modules for convenient e-Commerce.

Due to the large number of changes, in order to support multilingual, some components require translation. By default, the template supports the following languages: English, Russian, Ukrainian, Turkish and Romanian. Here is who helped with the translation: Mitza Dragan, 123Dragon, Taner İnanır, Vlad Miklyaev - thank you very much! You can also help with the translation of the template into your language or suggest edits for the translation, more details [here](https://github.com/trydalcoholic/opencart-materialize/issues/20).

## Development support
**Materialize Template** is a free theme, if you like the work done and you have the opportunity, please support the financial development of the project through:

| 😁 **Yandex.Money** 😅 | 👍 **PayPal** 😇 |
| :---: | :---: |
| [Yandex.Money](https://money.yandex.ru/to/41001413377821) | [PayPal](https://www.paypal.me/trydalcoholic) |

### Here are the main and global changes:
* The CSS styles used are pre-merged into one file, compressed on the go and integrated into the pages of the site; this approach minimizes HTTP requests, eliminates the wait for the CSS file to load, and allows the browser to start rendering the page faster without jumps and unexpected sketches;
* automatic generation of the most popular favicon sizes, to satisfy all requests for a variety of different devices;
* in the header of the site the necessary contact information (phone, mail, call back order, working time) is displayed;
* «Live search» starts immediately to search for the product as the query is entered in the search box;
* The "Dimension table" module is integrated - do you sell clothes? Specify flexible table for each product and help to determine the right size for your customers;
* integrated Blog module is a powerful and free tool at the service of the online store, write articles/news/posts, do reviews of product, create categories and subcategories, involve content managers, pointing them as the authors of the posts in the "Blog". Supported humanly understandable URL Default and SEOpro, Google Sitemap; 
* The module "Callback" is integrated - everything is very simple, customize the module to your liking and wait for call orders from your customers;
* "Quick order" module is integrated - the module adds a "Quick order" button to the product page. The minimum and mandatory input field is the customer's phone (additional fields are configured in the administrator part), after which the module sends a message to your work mail (you need to register the order yourself); 
* on the product category page:
* you can enable sorting taking into account the product "only in stock";
* ajax filter without reloading the page;
* the category description below the list of products — don't limit yourself to SEO optimization.
* Yandex.Map is integrated on the contacts page with automatic determination of the address of the store;
* integrated gif player;
* manufacturers' logos have been added to the manufacturers page;
* "Accept" button when editing the Goods, Category Pages, Blog Posts and Blog Categories.

### Here's how the product card was reworked:
* Micro-markup Schema.org is integrated;
* convenient viewing of goods photos. Tandem lazy downloading images, a convenient image slider and modern pop-up galleries create a convenient and nice-looking image slider, providing a high download speed and convenient viewing on any device;
* visible and display the product availability. The display automatically calculate the discount, attracting the attention of site visitors and have a positive impact on the purchase decision;
* After adding the product to the comparison, the link to the product comparison page will always be visible;
* product information includes the manufacturer's logo, the end date of the promotion, the article and a link to the product category;
* you can add an unlimited number of additional information fields for each product;
* It is possible to output a separate table of sizes for each product, if necessary;
* automatic updating of prices on the page when selecting options;
* options can have the status "default", allowing visitors to avoid unnecessary messages about the need to specify options when adding goods to the shopping cart;
* integrated quick order module on product page;
* you can add an unlimited number of additional tabs for each product;
* the button add to cart you can disable in admin panel;
* disabled automatic reverse linking for related products.

## Several real-time tests
* Micro-Marking Testing: [Product card](https://search.google.com/structured-data/testing-tool/u/0/#url=https%3A%2F%2Fmaterialize.myefforts.ru%2Fsmartphones%2Fiphone-smart%2Fiphone-7-plus-red-special-edition-256gb)
* The site is quickly loaded. Check the various pages of the site:
  - [Google PageSpeed](https://developers.google.com/speed/pagespeed/insights/)
  - [Pingdom Website Speed Test](https://tools.pingdom.com/)
  - [GTmetrix](https://gtmetrix.com/)
* Check out some other site tests:
  - Markup Validation Service: [main page](https://validator.w3.org/nu/?doc=https%3A%2F%2Fmaterialize.myefforts.ru%2F) and [product card](https://validator.w3.org/nu/?doc=https%3A%2F%2Fmaterialize.myefforts.ru%2Fsmartphones%2Fiphone-smart%2Fiphone-7-plus-red-special-edition-256gb)
  - Google Mobile-Friendly Test: [main page](https://search.google.com/search-console/mobile-friendly?id=aWnZIZ8aLvbIVq4R2tpuPQ) and [product card](https://search.google.com/search-console/mobile-friendly?id=zIJ0V8Q2y1WuyUJhOpN91w)

## Installation and removal
For a secure installation, you use the local theme folder and 2 installer files (OCMod.xml and SQL), which allows you to rollback changes in the event of conflict ituations. In order to avoid unforeseen errors, make sure you back up the site.
* [Documentation in English](https://github.com/trydalcoholic/opencart-materialize/blob/master/Documentation_eng.pdf)
* [Documentation in Russian](https://github.com/trydalcoholic/opencart-materialize/blob/master/Documentation_rus.pdf)
## Technologies used
* [jQuery](https://github.com/jquery/jquery)
* [Materialize](https://github.com/Dogfalo/materialize)
* [Material Design Icons](https://github.com/google/material-design-icons)
* [Slick](https://github.com/kenwheeler/slick)
* [PhotoSwipe](https://github.com/dimsemenov/PhotoSwipe)
* [Lazysizes](https://github.com/aFarkas/lazysizes)

| 😁 **Yandex.Money** 😅 | 👍 **PayPal** 😇 |
| :---: | :---: |
| [Yandex.Money](https://money.yandex.ru/to/41001413377821) | [PayPal](https://www.paypal.me/trydalcoholic) |

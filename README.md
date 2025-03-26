# Craft 5 Solo - Tutorial

This tutorial/workshop started as a pure Craft CMS starter as provided in the craftcms/craft package with 
the following additions:

* Added modules/_faux to enable autocompletion for some most frequently used variables in twig
* Moves example module to modules/main
* Set system timezone to Europe/Berlin
* Added /web/cpresources, /node_modules, /config/license.key to .gitignore
* Added more config settings and use fluent syntax in config/general.php

We then built a extended version of Craft's official tutorial.

## Tutorial setup

* Added setup/install for automated installation under ddev, imports a demo database with a user `admin/password`.
* Added multi-lingual support
* Added sections Home/Page/Post/SiteInfo/Topic
* Added fields for sections incl. a simple matrix content builder.
* Added sample content (mostly AI generated/translated)
* Added twig frontend templates with a lot of comments that should be helpful for beginners.
* Added CP styles
* Added CP template ui elements
* * Display existing drafts
* * Display usage for assets
* Basic Tailwind CSS setup

## Craft 5 Port

* Upgraded to Craft 5 (beta)
* Use generic fields and field instances
* Use icons/cards
* Updated custom CSS
* Use `render()` method for matrix field
* Use `eagerly()` method for eager loading
* Added 'Links'  block as an example for nested matrix entries
* Added 'Two Columns' block as an example column layout. You may want to change inner blocks editing from 'as inline-editable blocks' to 'as cards' in the `columnWrapperLeft/columnWrapperRight` field settings.

### Migration helpers

A couple of CLI commands / Twig templates to help with migration. 

* Stolen from a more complex project 
* Obsolete after migration, included for reference.

* `craft main/migration/check-runtime-errors` checks for runtime errors after initial migration
* `craft main/migration/check-consolidate-fields-candidates` checks for fields with identical settings that could be consolidated

* `/upgrade/fields` lists existing fields with their settings and their usage in sections.
* `/upgrade/fields?type=craft\fields\PlainText` filters for a specific field type, show all type specific settings.
* `/upgrade/fields?handles=text,text2,text3` filters for specific field handles, compare all type specific settings.

* `/upgrade/entrytypes` lists existing entry types with their usage and custom fields.

## DDEV Installation

* Clone repository
* `cd` into project directory
* Run `bash setup/install <projectname>`

## Screenshots

### The homepage

![Screenshot home page](/screenshot-home.jpg)

### The post index page

![Screenshot post index page](/screenshot-posts.jpg)

### Cards in Control Panel

![Screenshot cards](/screenshot-cards.jpg)

### Example for matrix in matrix

![Screenshot nested entries](/screenshot-nested.jpg)

### CP UI elements

![Screenshot drafts ui element](/screenshot-drafts.jpg)

![Screenshot usages ui element](/screenshot-usages.jpg)


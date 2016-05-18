# Change Log

## [3.0.0] - 2016-05-18

### Added

* Custom embed templates and styling.
* Support for WordPress logo feature.
* Editor stylesheet URI functions. Child themes can now serve up `css/editor-style.min.css` if they want.
* German translation files.
* Feed icon for social nav menu.
* Support for selective refresh of widgets in the customizer.

### Changed

* Updated to latest Hybrid Core framework.
* Separated media CSS into its own file to be reused where needed.
* Combined theme's media player CSS with the `theme-mediaelement` project CSS.
* Better mobile phone menu handling (check child themes for 540px and below).
* Mobile menu now appears on iPad landscape view (1024px).
* Header image is hidden on mobile phones (540px and below).
* Default Primary sidebar widgets changed to Categories, Tags, and Meta widgets.

### Fixed

* Use correct check in Primary sidebar for getting the theme layout.

### Removed

* Code for old custom header feature in WordPress admin.
* Support for galleries and media player in visual editor (WP makes it next to impossible to style).
* Theme Medialement project as a sub-module (just bringing in the CSS manually).

## [2.1.2] - 2016-03-07

### Fixed

* Fixes the layout check for the Primary sidebar. Widgets did not appear when global layout was overwritten.

## [2.1.1] - 2016-02-22

### Fixed

* Wrong path for file check.

## [2.1.0] - 2016-02-22

### Added

* New welcome/info sub-page under Appearance in admin.
* Partial Russian (`ru_RU`) translation.

### Changed

* Updated Norwegian (`nb_NO`) translation.

## [2.0.0] - 2016-01-07

### Added

* Added Japanese (`ja`), Brazilian Portuguese (`pt_BR`), and Norwegian (`nb_NO`) language files.

### Changed

* Upgraded to version 3.1.0-dev of the Hybrid Core framework.
* Upgraded to version 3.4.1 of Genericons.
* Upgraded to version 20141221 of Theme Mediaelement.
* Author URI now points to http://themehybrid.com
* Use WP's `the_archive_title()` for archive titles.
* Use WP's `the_archive_description()` for archive descriptions.
* Use WP's `the_post_pagination()` to handle numeric pagination.
* New, updated screenshot with larger size.
* New text strings added, updated POT.
* General code cleanup.

### Fixed

* Secondary menu button text now hidden below 580px to help avoid clashing with site title.
* Added missing comment moderation notice.
* Embed wrapping for responsive embeds.  Now, we use PHP to limit to a specific list of video providers.
* CSS typo.

### Removed

* Support for admin-side custom header functionality, which is now all handled in the customizer.
* Custom widgets (removed from Hybrid Core). Users should use the [Widgets Reloaded](http://themehybrid.com/plugns/widgets-reloaded) plugin.

## [1.2.0]

* Upgraded to Hybrid Core version 2.0.0-rc-1.
* Made sure styles for default WordPress widgets are handled since Hybrid Core dropped widgets.
* Major accessibility improvements across the entire theme. It's not ready for the `accessibility-ready` tag yet, but it's close.
* Changed the way the search form in the Primary menu behaves (slides out rather than opening below).
* Minor correction in inconsistent blockquote cite CSS.
* Added Spanish translation files.

## [1.1.1]

* Updated to Hybrid Core version 2.0.0-beta-2.
* Fixed missing error text on 404 and error pages.
* Corrected typo with border style in `style.css`.
* Fixed flash of missing header image when removing the image in theme customizer.
* Use `.wp-caption .wp-caption-text` so that caption text styles don't mess up gallery captions in visual editor.
* Make sure sub-lists of the comments list use the `<ol>` element.
* Added Swedish translation files.
* Added support for the [Entry Views](http://wordpress.org/plugins/entry-views) plugin.
* Make sure there's a line break before showing categories on singular views of Quote and Status posts.
* Added an exception for Amazon embeds in the embed wrap JavaScript.
* Added the `left-sidebar`, `right-sidebar`, and `responsive-layout` tags to `style.css`.

## [1.1.0]

* Updated to Hybrid Core version 2.0.0-beta-1.
* Only use `customize.min.css` when `SCRIPT_DEBUG` is disabled.
* Embed JavaScript only targets embeds within posts.
* Re-added Dribbble support in the Social menu, which was accidentally removed.
* Fixed Mediaelement.js CSS padding issue introduced in WP 3.9.
* Full support and styling for WP 3.9's playlist feature.
* Corrected missing color definitions in the visual editor, which was introduced in WP 3.9.
* Fixed broken method of getting media info, which was a bug introduced in WP 3.9.

## [1.0.1]

* Updated to version 3.0.3 of Genericons.
	* Uses the new "fullscreen" icon for media player.
	* Dropbox supported in the Social menu.
* Fix for JS conflict with Gravity Forms embeds.
* Fixed Subsidiary sidebar column count when using a single widget.
* Better CSS for Japanese language (`css/ja.css`).
* Added French language files.
* Added Romanian language files.

## [1.0.0]

* Everything's new!

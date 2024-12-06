=== Embed GCalendar Anywhere===

Contributors: Song M. Kim
Tags: google calendar, iframe
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily embed multiple public Google Calendars anywhere on your WordPress site.

== Description ==

Embed GCalendar Anywhere allows you to add multiple public Google Calendars to your site with customizable settings. Choose colors, set iframe dimensions, and select a view mode (Month, Week, Agenda) for a tailored calendar display.

== Installation ==

1. Upload the `embed-gcalendar-anywhere` folder to the `/wp-content/plugins/` directory or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Settings > Embed GCalendar anywhere** to configure your calendar IDs, colors, iframe size, and timezone.
4. Use the shortcode `[embed-gca]` to embed the calendar on your pages or posts. 
5. You can change `mode` to "WEEK" or "AGENDA" as needed by `[embed-gca mode="WEEK"]`ro `[embed-gca mode="AGENDA"]`
6. The default `[embed-gca]` is same with `[embed-gca mode="MONTH"]`.

== Frequently Asked Questions ==

= How do I switch between calendar views? =
To change the calendar view, use the `mode` attribute in the shortcode. For example:
- `[embed-gca mode="WEEK"]` for the weekly view.
- `[embed-gca mode="AGENDA"]` for the agenda view.

= Can I display multiple public Google Calendars at once? =
Yes! You can add multiple calendar IDs in the settings and assign each one a unique color. The plugin will combine and display them in a single calendar view.

= How do I customize the calendar's timezone? =
In the plugin settings, use the dropdown menu to select the desired timezone. This will adjust the calendar events to display in the selected timezone.

= Can I customize the iframe size? =
Absolutely! You can set both width and height for the calendar's iframe in the plugin settings.

== Screenshots ==

**Settings Page** - Configure calendar IDs, colors, iframe size, and timezone.

== Changelog ==

= 1.0.0 =
* Initial release with support for embedding multiple public Google Calendars.
* Customizable calendar colors, iframe size, and timezone settings.
* Support for multiple view modes: Month, Week, Agenda.

== Upgrade Notice ==

= 1.0.0 =
First release of Embed GCalendar Anywhere. Embed public Google Calendars with enhanced options for your WordPress site.

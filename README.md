# Typemill Cookie Consent

A lightweight cookie consent plugin for [Typemill](https://typemill.net) that integrates the popular [CookieConsent](https://github.com/orestbida/cookieconsent) library by orestbida. It displays a customizable cookie banner and a preferences modal so visitors can manage their cookie choices.

Developed by [Giuseppe Chiesa](https://g-c.dev) / [g-c.dev](https://g-c.dev).

Source code: [github.com/gchiesa/typemill-cookieconsent](https://github.com/gchiesa/typemill-cookieconsent)

## Requirements

- Typemill 1.x or higher
- PHP **8.2 – 8.5** (tested on PHP 8.5.9)

## Installation

1. Download the plugin and upload the `cookieconsent` folder to the `/plugins` directory of your Typemill installation.
2. Log in to the Typemill admin panel.
3. Go to **Settings → Plugins** and activate the **Cookie Consent** plugin.
4. Open the plugin settings and fill in the cookie category descriptions (see below).

## Configuration

In the plugin settings you can define the descriptions shown in the consent modal for each cookie category:

| Setting | Description |
|---------|-------------|
| `message_base` | Description for **necessary cookies** (always enabled). Explain why these are required for core functionality such as navigation and security. |
| `message_analytics` | Description for **analytics cookies**. Explain how you collect usage data to improve the site. |
| `message_functionality` | Optional description for **functionality cookies**. Use this for features that enhance the experience (e.g., remembering preferences). |
| `message_marketing` | Optional description for **marketing cookies**. Use this for personalized advertising or tracking. |
| `legal_and_privacy_url` | URL of your legal/privacy page. Displayed in the modal footer and the *More information* section. |

If a message field is left empty, the corresponding cookie category is **not shown** in the preferences modal.

## Features

- Cookie consent banner with **accept all**, **reject all**, and **manage preferences** actions.
- Preferences modal grouped by cookie category.
- Automatic injection of the required JavaScript and CSS from CDN.
- Automatic CSP whitelist entries for `cdn.jsdelivr.net` and `unpkg.com` via the Typemill `onCspLoaded` event.
- Settings are escaped safely for JavaScript and HTML output.

## CDN Resources

The plugin loads the following external assets:

- JavaScript: `//unpkg.com/vanilla-cookieconsent@3.1.0/dist/cookieconsent.umd.js`
- CSS: `https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css`

Make sure your Content Security Policy (CSP) allows these domains. The plugin adds them automatically when the Typemill CSP event is active.

## License

MIT

## Versions

### Version 1.1.0

- Verified compatibility with PHP 8.5.
- Added safe JavaScript/HTML escaping for all admin-defined settings (descriptions, URL) to prevent broken inline JS when values contain quotes, backslashes, or special characters.
- Description fields are stripped of HTML tags so the cookie modal stays text-only.
- Hardened `onCspLoaded` so it does not add duplicate CSP domains.
- Removed the unused `onSettingsLoaded` event handler and the unused `Settings` import.
- Added a detailed README.

### Version 1.0.1

- Initial release.

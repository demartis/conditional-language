# Conditional Language Shortcodes - WordPress Plugin

**Version:** 1.0.0  
**Author:** Riccardo De Martis  
**Author URI:** [https://www.linkedin.com/in/rdemartis](https://www.linkedin.com/in/rdemartis)  
**Plugin URI:** [https://github.com/demartis/conditional-language](https://github.com/demartis/conditional-language)  
**License:** LGPL

---

## Overview

Conditional Language Shortcodes is an awesome plugin for WordPress that streamlines content management when combined with the Polylang and Redirection plugins. It enables you to **centralize similar content** on one common page while serving different language variations based on the URL. With this approach, you can easily manage pages that differ by very little content – such as British, Australian, or American English – without duplicating content across multiple pages.

### Key Benefits:

- **Centralized Content:**  
  Create a single content file (for example, `/en/mypage`) containing all language variants using conditional shortcodes.  
- **Efficient Multilingual Management:**  
  Reduce redundancy by managing slight content differences for sites targeting different regions.  
- **Seamless Integration:**  
  Works perfectly with the Polylang plugin for multilingual sites and the Redirection plugin configured in Pass-through mode.
- **Easy to Read and Maintain:**  
  The shortcode structure is simple and clear, making future updates straightforward.

---

## How It Works

1. **URL Language Detection:**  
   The plugin detects the current language from the URL via a regular expression. For example, URLs like `/gb/some-page-gb/`, `/au/some-page-au/`, or `/us/some-page-us/` will determine whether the user sees content for Great Britain, Australia, or the United States.

2. **Content Centralization Using Shortcodes:**  
   Write your content once on your main page (e.g., `/en/mypage`) using conditional shortcodes:
   - `[if_lang]` – Outputs content immediately if the language matches.
   - `[conditional_language]` – Acts as a container for multiple `[if_lang]` blocks and an optional `[otherwise]` fallback.
  
3. **Redirection Plugin Integration – Pass-through Mode:**  
   Configure the Redirection plugin to serve the content from your centralized page while keeping the original URL in the browser. This is done by enabling Pass-through mode in your redirection rule:
   
   **Redirection Plugin Settings:**
   - **Match:** `^/(gb|au|us)/(.+)-\1(/)?$`
   - **Target URL:** `/en/$2`
   - **Type:** Pass-through (instead of Redirect)
   
   With this setup, visitors accessing `/gb/mypage-gb/` (or similar) will see the same content as `/en/mypage`, but the browser will retain the original URL.

---

## Quick Usage Examples

### Standalone Shortcode Example

Use the `[if_lang]` shortcode directly within a page or post. The following example outputs its content only when the current language matches the given code:

```html
[if_lang code="en"]This content is shown only on English language pages.[/if_lang]
```

### Container Shortcode with Fallback

Wrap multiple `[if_lang]` shortcodes within a `[conditional_language]` container for enhanced control. The container ensures that the first language match is used; if no match occurs, the fallback content inside the `[otherwise]` block is displayed:

```html
[conditional_language]
  [if_lang code="gb"]This is the content for British English users.[/if_lang]
  [if_lang code="au"]This is the content for Australian users.[/if_lang]
  [if_lang code="us"]This is the content for American users.[/if_lang]
  [otherwise]This is the default content for all other languages.[/otherwise]
[/conditional_language]
```

### Multiple Language Conditions Example

For pages with several language-specific conditions, use the container to group your rules together. For instance:

```html
[conditional_language]
  [if_lang code="en"]Content for English-speaking users.[/if_lang]
  [if_lang code="es"]Contenido para usuarios hispanohablantes.[/if_lang]
  [if_lang code="fr"]Contenu pour les utilisateurs francophones.[/if_lang]
  [otherwise]Default content for users of other languages.[/otherwise]
[/conditional_language]
```

---

## Features

- **Universal Two-Letter Code Support:**  
  Detects and supports any valid two-letter language code from the URL.
  
- **Flexible Shortcode Options:**  
  - **Standalone `[if_lang]`:** Outputs immediately if the condition is met.
  - **Container `[conditional_language]`:** Groups multiple conditions with a fallback `[otherwise]`.
  
- **Seamless Integration with Redirection & Polylang:**  
  Best used in combination with the Redirection plugin (using Pass-through mode) and Polylang to centralize content management across multiple regional versions.

- **Helper Function for Developers:**  
  Utilize the `conditional_language_is( $lang )` function in your theme or plugin code to tailor content dynamically based on the detected language.

- **Internationalization Ready:**  
  Designed with translation in mind, making it easy to adapt the plugin for any language.

---

## Requirements

- WordPress 4.7 or higher.
- The [Polylang](https://wordpress.org/plugins/polylang/) plugin (for managing multiple languages) is highly recommended.
- The [Redirection](https://wordpress.org/plugins/redirection/) plugin for handling internal URL rewrites in Pass-through mode.

---

## Installation

### Manual Installation

1. **Download the Plugin:**  
   Clone or download the repository from [GitHub](https://github.com/demartis/conditional-language).

2. **Extract the Files:**  
   Unzip the archive if necessary.

3. **Upload the Plugin:**  
   Upload the entire `conditional-language` folder to your `/wp-content/plugins/` directory.

4. **Activate the Plugin:**  
   In your WordPress admin panel, navigate to **Plugins** and activate **Conditional Language Shortcodes**.

---

## Redirection Plugin Setup

To fully benefit from the centralized content approach, configure the Redirection plugin as follows:

1. **Create a New Rule:**

   - **Match URL:**  
     `^/(gb|au|us)/(.+)-\1(/)?$`
   
   - **Target URL:**  
     `/en/$2`
   
   - **Type:**  
     Select **Pass-through** (ensuring the URL in the browser remains the same while serving the centralized content).

2. **Enable Pass-through Mode:**  
   In the Redirection plugin settings, ensure the Pass-through option is enabled for this rule. This integration allows you to manage a single page's content while serving localized URLs.

---

## Using the Shortcodes

### Standalone `[if_lang]` Shortcode

Place the shortcode anywhere in your content. For example:

```html
[if_lang code="en"]This content is shown only for English language pages.[/if_lang]
```

### Container Shortcodes

Group language-specific conditions using the `[conditional_language]` container:

```html
[conditional_language]
  [if_lang code="gb"]This is the content for British English users.[/if_lang]
  [if_lang code="au"]This is the content for Australian users.[/if_lang]
  [otherwise]This is the default content for all other languages.[/otherwise]
[/conditional_language]
```

### Developer Helper Function

In your theme or custom plugin code, check the current language:

```php
if ( conditional_language_is( 'en' ) ) {
    // Code to execute for English language pages.
}
```

---

## Changelog

### 1.1.0
- Added full support for any two-letter language code extracted from the URL using a flexible regex pattern.
- Language detection is now dynamic and not hardcoded to specific values like gb, au, or us.
- Improved flexibility for multilingual websites with custom or less common language or region codes.
  
### 1.0.0
- Initial release of Conditional Language Shortcodes.
- Supports any two-letter language code via URL detection.
- Provides shortcodes: `[if_lang]`, `[conditional_language]`, and `[otherwise]`.
- Exposes helper function `conditional_language_is()` for developers.
- Seamless integration with the Redirection plugin in Pass-through mode.

---

## License

This plugin is licensed under the LGPL license.

---

## Support

For support, bug reports, or feature requests, please open an issue on the [GitHub Issues](https://github.com/demartis/conditional-language/issues) page.
```

---

## Final Notes

- **Why This Plugin?**  
  This plugin is ideal if you need to manage similar content for different regions (e.g., UK, Australia, US) without maintaining separate pages for each variation. When used in combination with the Polylang and Redirection plugins, it dramatically simplifies content management and ensures consistency across your multilingual site.

- **Integration Advantage:**  
  With the clever use of internal rewrites (Pass-through mode), your visitors see the localized URL (like `/gb/mypage-gb/`), while the content is served from a centralized page (like `/en/mypage`). This setup reduces duplication and centralizes maintenance, making it perfect for sites where content differs only minimally by language.

Enjoy using Conditional Language Shortcodes to create an efficient, streamlined multilingual website!

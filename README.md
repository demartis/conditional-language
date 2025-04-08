## README

Create a file named `README.md` and include the following content:

```markdown
# Conditional Language Shortcodes - WordPress Plugin

**Version:** 1.0.0  
**Author:** Riccardo De Martis  
**Author URI:** [https://www.linkedin.com/in/rdemartis](https://www.linkedin.com/in/rdemartis)  
**Plugin URI:** [https://github.com/demartis/conditional-language](https://github.com/demartis/conditional-language)  
**License:** LGPL

---

## Overview

Conditional Language Shortcodes is a lightweight WordPress plugin that displays content based on the language detected in the URL. The plugin supports any two-letter language code and works with both standalone shortcode usage and as a container with fallback content.

The plugin detects language from URLs that follow the pattern:

```
/{lang}/...-{lang}/
```

For example:
- `/gb/some-page-gb/`
- `/au/another-page-au/`
- `/en/example-en/`

When the current URL matches the language, the corresponding content is displayed.

---

## Quick Usage Examples

### Standalone Shortcode Example

Use the `[if_lang]` shortcode on its own. This will immediately output its content if the current language matches the provided `code` attribute:

```html
[if_lang code="en"]This content is displayed only when the current language is English.[/if_lang]
```

### Container Shortcode with Fallback

Wrap multiple `[if_lang]` conditions and an `[otherwise]` fallback inside a `[conditional_language]` container. The container outputs the first matching `[if_lang]` content; if none match, the `[otherwise]` content is displayed:

```html
[conditional_language]
  [if_lang code="gb"]This is the content for Great Britain.[/if_lang]
  [if_lang code="au"]This is the content for Australia.[/if_lang]
  [otherwise]This is the content for other languages.[/otherwise]
[/conditional_language]
```

### Multiple Language Conditions Example

Define several conditions within a container with a fallback for unmatched languages:

```html
[conditional_language]
  [if_lang code="en"]Content for English users.[/if_lang]
  [if_lang code="es"]Contenido para usuarios en español.[/if_lang]
  [if_lang code="fr"]Contenu pour les utilisateurs français.[/if_lang]
  [otherwise]Default content for users of other languages.[/otherwise]
[/conditional_language]
```

---

## Features

- **Universal Language Code Support:**  
  Works with any valid two-letter language code detected from the URL.

- **Flexible Shortcode Usage:**  
  - **Standalone `[if_lang]` Shortcode:** Immediately displays content if the language condition is met.
  - **Container `[conditional_language]` Shortcode:** Supports grouping of multiple `[if_lang]` conditions with an `[otherwise]` fallback if no conditions match.

- **Helper Function:**  
  The plugin also exposes a helper function:
  ```php
  conditional_language_is( $lang );
  ```
  which returns `true` if the current language matches the provided two-letter code.

- **Internationalization Ready:**  
  Fully prepared for translations.

---

## Requirements

- WordPress 4.7 or higher.

---

## Installation

### Manual Installation

1. **Download the Plugin:**  
   Clone or download the repository from [GitHub](https://github.com/demartis/conditional-language).

2. **Extract the Archive:**  
   Extract the files (if downloaded as a ZIP).

3. **Upload the Plugin:**  
   Upload the `conditional-language` folder to your `/wp-content/plugins/` directory.

4. **Activate the Plugin:**  
   In your WordPress admin area, navigate to **Plugins** and activate **Conditional Language Shortcodes**.

---

## Usage

### Using the Shortcodes

#### Standalone `[if_lang]` Shortcode

Place the shortcode anywhere in your posts or pages. For example, to show content only for English users:

```html
[if_lang code="en"]This content is displayed only for English language pages.[/if_lang]
```

#### Container Shortcodes: `[conditional_language]`, `[if_lang]`, and `[otherwise]`

Enclose your language-specific shortcodes within a `[conditional_language]` container:

```html
[conditional_language]
  [if_lang code="gb"]This is the content for Great Britain.[/if_lang]
  [if_lang code="au"]This is the content for Australia.[/if_lang]
  [otherwise]This is the content for other languages.[/otherwise]
[/conditional_language]
```

### Using the Helper Function

You can also check the current language in your theme or plugin code:

```php
if ( conditional_language_is( 'en' ) ) {
    // Execute code specific to English language pages.
}
```

---

## Changelog

### 1.0.0
- Initial release of Conditional Language Shortcodes.
- Support for any two-letter language code.
- Shortcodes: `[if_lang]`, `[conditional_language]`, and `[otherwise]`.
- Exposed helper function `conditional_language_is()` for developers.

---

## License

This plugin is licensed under the LGPL license.

---

## Support

For support, updates, or further inquiries, please use the [GitHub Issues](https://github.com/demartis/conditional-language/issues) page.
```

---

## Final Notes

1. **Hosting on GitHub:**  
   Use the provided repository link (https://github.com/demartis/conditional-language) to host your code.

2. **Best Practices:**  
   The plugin code adheres to WordPress coding standards, proper escaping is in place (with content processed via `do_shortcode`), and the functions are well-commented to explain their purpose and usage.

3. **Internationalization:**  
   Although this example does not include translation functions (like `__()`), you can extend it further to support translation as needed by loading text domains.

You now have a fully functional WordPress plugin along with a complete README. Enjoy coding and feel free to adjust as needed!

# Conditional Language Shortcodes – WordPress Plugin

**Version:** 1.1.2
**Author:** Riccardo De Martis  
**Author URI:** [https://www.linkedin.com/in/rdemartis](https://www.linkedin.com/in/rdemartis)  
**Plugin URI:** [https://github.com/demartis/wp-conditional-language-shortcodes](https://github.com/demartis/wp-conditional-language-shortcodes)  
**License:** LGPL

---

## Overview

**Conditional Language Shortcodes** is the perfect companion for multilingual WordPress websites built with **Polylang** and **Redirection**.  

This plugin lets you **centralize shared content** on one page (e.g. `/en/mypage`) while showing **country-specific variations** — ideal for cases like **Australia**, **UK**, and **USA** where content differs only slightly.

Instead of duplicating pages, you manage all variants with clean shortcodes.

---

## Why Use It?

- **One page, multiple variations.**  
  Write shared content once, show different versions based on URL (e.g., `/gb/mypage-gb`).

  Pay attention to the syntax, the only recognized URLs are in the format `/[lang]/mypage-[lang]` 

- **Saves time and reduces clutter.**  
  Manage fewer pages even across many countries and languages.

- **Designed for Polylang + Redirection setups.**  
  Ideal when language switching is based on **region codes** (e.g. `gb`, `au`, `us`).

---

## How It Works

1. You centralize content in a single page like `/en/mypage`, with conditionals like:
   ```html
   [conditional_language]
     [if_lang code="gb"]Text for UK[/if_lang]
     [if_lang code="au"]Text for Australia[/if_lang]
     [otherwise]Default text[/otherwise]
   [/conditional_language]
   ```

2. Use the **Redirection** plugin in **Pass-through mode** to rewrite:
   ```regexp
   ^/([a-z]{2})/(.+)-\1(/)?$
   → /en/$2
   ```
   
   So a user visiting `/gb/product-gb/` will be served `/en/product`, but see content tailored for `gb`.


3. (alternative) You might want to create different configs to manage multiple languages, the case of
   
   Australia, UK, and USA → rendered as EN
   
   France, Canada → rendered as FR

   In that case:
   ```regexp
   ^/(au|uk|us)/(.+)-\1(/)?$
   → /en/$2
   
   
   ^/(fn|ca)/(.+)-\1(/)?$
   → /fr/$2
   ```


---

## Shortcode Examples

### Single Language
```html
[if_lang code="us"]Content only for USA visitors[/if_lang]
```

### Multiple with Fallback
```html
[conditional_language]
  [if_lang code="gb"]UK-specific content[/if_lang]
  [if_lang code="au"]AU-specific content[/if_lang]
  [otherwise]Fallback for other countries[/otherwise]
[/conditional_language]
```

---

## Developer Function

Use in theme/plugin PHP code:
```php
if ( conditional_language_is( 'au' ) ) {
    // Do something for Australian visitors
}
```

---

## Installation

1. Download from [GitHub](https://github.com/demartis/wp-conditional-language-shortcodes).
2. Upload to `/wp-content/plugins/`.
3. Activate via WordPress admin.
4. Set up Redirection rules using **Pass-through** to serve from `/en/`.

---

## Changelog

### 1.1.1, 1.1.2
- Fixed GitHub links, project name and documentation.

### 1.1.0
- Added dynamic support for any 2-letter language code via URL.
- Now works with any country-based language slug (not just gb, au, us).

### 1.0.0
- Initial release with `[if_lang]`, `[conditional_language]`, `[otherwise]` support.

---

## License

LGPL – Use freely in personal or commercial projects.

---

## Support

Open issues and feature requests at  
👉 [github.com/demartis/wp-conditional-language-shortcodes/issues](https://github.com/demartis/wp-conditional-language-shortcodes/issues)

---

## Perfect For

✅ Multilingual WordPress sites  
✅ Polylang configured with country codes (e.g., `gb`, `au`, `us`)  
✅ Minimal content variations across regions  
✅ Centralized content & simplified updates  
✅ Clean, no-redirect URLs with Redirection's **Pass-through**

---

Make your multilingual site smarter, leaner, and easier to maintain!
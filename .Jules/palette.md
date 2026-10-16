## 2026-05-31 - Missing ARIA Labels on Icon-Only Buttons
**Learning:** Icon-only buttons (like the mobile menu and carousel controls) across the application currently lack `aria-label` attributes, rendering them inaccessible to screen readers. Furthermore, the FontAwesome icons themselves are not hidden from assistive technologies.
**Action:** Always ensure that any button containing only an icon has a descriptive `aria-label` attribute (in Spanish, matching the site's language) and that the icon element itself has `aria-hidden="true"`.

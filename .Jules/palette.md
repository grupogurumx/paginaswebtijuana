## 2026-07-03 - Focus Rings on Dark Backgrounds
**Learning:** In Tailwind, focus rings can disappear visually on dark sections (like the hero slider or footer) if there isn't enough contrast. Adding an explicit `focus-visible:ring-offset-gray-900` (or a similar dark color) alongside the standard ring is necessary so the focus outline remains highly visible for keyboard users.
**Action:** Always check the parent element's background color. If it's dark, manually configure a dark ring offset class (`ring-offset-gray-900`) along with the focus ring on interactive components.

## 2024-06-28 - Focus rings on dark backgrounds
**Learning:** Using default focus rings on dark backgrounds (like `#111827` / `bg-gray-900`) leads to poor contrast. The default offset color assumes a light background.
**Action:** When adding `focus-visible` styles on dark backgrounds in Tailwind, always specify a dark ring offset using `focus-visible:ring-offset-gray-900` (or the specific background color) to ensure the focus ring is clearly visible and accessible.

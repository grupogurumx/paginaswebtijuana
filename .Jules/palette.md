## 2026-06-29 - Focus Rings on Dark Backgrounds
**Learning:** When implementing keyboard focus rings on dark backgrounds (like the gray-900 footer), standard focus rings can disappear. Using `focus-visible:ring-offset-gray-900` is essential for proper contrast and visibility in this design system.
**Action:** Always check the background color context when adding focus rings and use the appropriate `ring-offset-{color}` utility.

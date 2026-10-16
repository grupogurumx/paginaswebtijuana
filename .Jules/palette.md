## 2024-05-17 - Tailoring focus-visible offsets for Dark Themes
**Learning:** Default Tailwind focus rings (`ring-2`) can blend into dark backgrounds like footers or hero sections, rendering keyboard navigation invisible to users.
**Action:** When implementing keyboard focus rings using Tailwind CSS in this project, use `focus-visible:ring-offset-gray-900` for dark backgrounds (like the footer or hero section) to ensure proper contrast and visibility.

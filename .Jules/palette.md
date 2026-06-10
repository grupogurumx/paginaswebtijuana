## 2024-05-24 - Interactive icon-only elements lacking ARIA labels
**Learning:** Found multiple icon-only interactive elements (mobile menu button, slider controls, social links) lacking `aria-label`s and `focus-visible` styles, making them inaccessible to screen readers and difficult to use via keyboard navigation.
**Action:** Added `aria-label` to all icon-only buttons/links, and added `focus-visible:ring-2 focus-visible:ring-secondary` utility classes to ensure visible focus states.

## 2024-06-18 - Icon-Only Button Accessibility
**Learning:** Found a pattern where interactive elements containing only icons (mobile menu toggle, slider controls, social links) lack accessible names (`aria-label`) and visible keyboard focus states (`focus-visible`). This makes them inaccessible to screen readers and difficult to navigate via keyboard.
**Action:** When working on this app's components, always ensure icon-only interactive elements receive descriptive `aria-label`s and visible focus states using utility classes like `focus-visible:ring-2`.

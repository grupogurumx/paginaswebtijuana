## 2024-05-18 - Tailwind focus-visible Offset Patterns
**Learning:** For sections with dark backgrounds (like the footer or hero section), standard `focus-visible:ring-2` can blend into the background, defeating the purpose of a focus indicator for keyboard navigation.
**Action:** Always pair `focus-visible:ring-2 focus-visible:ring-white` with `focus-visible:ring-offset-2 focus-visible:ring-offset-gray-900` on dark sections to ensure high contrast and clear visibility of the focus ring.

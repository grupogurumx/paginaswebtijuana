## 2024-06-13 - Missing Semantic Bindings in Forms
**Learning:** Found that the primary contact form lacked semantic bindings (`for` and `id` attributes) linking labels to inputs/textareas, severely impacting screen reader usability, as well as a lack of visual indicators for `required` fields.
**Action:** When adding new forms or modifying existing ones in this design system, ensure `for`/`id` linking is universally applied and required fields are visually marked (e.g. `<span class="text-red-500" aria-hidden="true">*</span>`).

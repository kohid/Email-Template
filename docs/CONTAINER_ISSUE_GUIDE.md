````markdown name=docs/CONTAINER_ISSUE_GUIDE.md
# Container Widget & Canvas Troubleshooting Guide

This guide explains how the included snippets integrate with the editor and how to troubleshoot & extend the Container Widget and canvas device sizing.

## Files added
- `snippets/drag-drop.js` — basic drag/drop API with HTML5 and pointer fallback. Exposes `tdtEditor.makeDraggable`, `tdtEditor.makeDropContainer`, `tdtEditor.insertWidgetHtml`.
- `snippets/responsive-canvas.css` — canvas and viewport styles and device mode classes.
- `configs/widget-properties.json` — canonical widget schema you can use to generate settings UIs.
- `docs/CONTAINER_ISSUE_GUIDE.md` — this guide.
- `examples/editor-demo.html` — a simple working demo showing a palette, draggable widgets and a container that accepts drops.

## Quick integration steps
1. Include `snippets/responsive-canvas.css` in your editor page and ensure a wrapper element toggles one of these classes: `device-desktop`, `device-tablet`, `device-mobile` on the root editor element. The `.canvas` width will respond to that.

2. Use `tdtEditor.makeDraggable(el)` for each palette item you want to make draggable. Give items a `data-widget-type` attribute to distinguish widget types.\n3. Use `tdtEditor.makeDropContainer(containerEl, onDropCallback)`. The callback will receive a payload `{type, html}` and the original event. Use `tdtEditor.insertWidgetHtml` (or your framework state update) to insert a new widget instance.

4. In frameworks (React/Vue): do not mutate DOM directly. Instead, use the onDropCallback to update the application state (add a widget record) and let the renderer create DOM nodes. This avoids state/DOM mismatches that cause dropped elements to disappear.

## Common issues and fixes
- Problem: Drops are ignored on the container.\n  Fixes: Confirm the container has the drop handlers attached, confirm `dragover` handler calls `event.preventDefault()`, ensure `pointer-events` isn't disabled and no overlay element is intercepting events.\n- Problem: Drag works on desktop but not mobile.\n  Fixes: Mobile often doesn't support HTML5 drag/drop. Use the pointer fallback (we store payload on `window.__tdt_drag_payload`) or use a touch-normalizing library (Interact.js, Draggable, SortableJS).\n- Problem: Canvas device toggle changes nothing.\n  Fixes: Ensure you toggle the class on an ancestor of `.canvas` (e.g., `.editor-root`). If you use inline styles, update them directly from device mode state.\n## Extending widget settings UI
Use `configs/widget-properties.json` as a source of truth. Create UI controls bound to each field and write to widget settings objects. Support per-device overrides by nesting device keys (e.g., `font_size.desktop`, `font_size.mobile`).

## Elementor-like container
Make the container expose an inner insertion element (like `.tdt-container-inner`) where children are appended. Accept drops on that inner element and treat it as the authoritative children holder.

## Example debug checklist
1. Open devtools > Elements, check the container structure and classes.\n2. In devtools > Event Listeners, inspect `dragover` and `drop` on the container.\n3. Add `console.log` to `dragstart`, `dragover`, `drop` to trace payloads.\n4. Test the included `examples/editor-demo.html` page in desktop and mobile emulator mode.\n
````

// snippets/drag-drop.js
// Basic drag & drop handlers with a pointer/touch fallback for an editor canvas.

(function (global) {
  'use strict';

  function makeDraggable(el) {
    if (!el) return;
    el.setAttribute('draggable', true);
    el.addEventListener('dragstart', function (e) {
      const payload = { type: el.dataset.widgetType || 'widget', html: el.outerHTML }
      try {
        e.dataTransfer.setData('text/plain', JSON.stringify(payload));
        e.dataTransfer.effectAllowed = 'move';
      } catch (err) {
        console.warn('dragstart: dataTransfer not available', err);
      }
      // For pointer fallback we store the payload globally
      global.__tdt_drag_payload = payload;
    });
  }

  function makeDropContainer(container, onDropCallback) {
    if (!container) return;

    container.addEventListener('dragover', function (e) {
      e.preventDefault();
      try { e.dataTransfer.dropEffect = 'move'; } catch (err) {}
      container.classList.add('tdt-drop-target');
    });

    container.addEventListener('dragleave', function () {
      container.classList.remove('tdt-drop-target');
    });

    container.addEventListener('drop', function (e) {
      e.preventDefault();
      container.classList.remove('tdt-drop-target');
      let payload = null;
      try {
        const raw = e.dataTransfer.getData('text/plain');
        payload = raw ? JSON.parse(raw) : null;
      } catch (err) {
        // fallback to pointer payload if set
        payload = global.__tdt_drag_payload || null;
      }
      if (payload) {
        onDropCallback(payload, e);
      } else {
        console.warn('Drop received but no payload found');
      }
    });

    // Pointer/touch fallback: simple implementation that listens for pointerup on container
    // Useful for touch devices where native HTML5 drag/drop is not available.
    container.addEventListener('pointerup', function (e) {
      // If a pointer-based drag set a global payload, accept it here.
      const payload = global.__tdt_drag_payload;
      if (payload) {
        // compute if pointer is inside container (it is, since event fired on it)
        onDropCallback(payload, e);
        global.__tdt_drag_payload = null;
      }
    });
  }

  // Utility to insert widget HTML into a target container safely (returns the inserted element)
  function insertWidgetHtml(targetInner, widgetHtml) {
    if (!targetInner) return null;
    // Create a wrapper element to parse the HTML string
    const template = document.createElement('template');
    template.innerHTML = widgetHtml.trim();
    const node = template.content.firstElementChild;
    if (!node) return null;
    targetInner.appendChild(node);
    return node;
  }

  // Expose API
  global.tdtEditor = global.tdtEditor || {};
  global.tdtEditor.makeDraggable = makeDraggable;
  global.tdtEditor.makeDropContainer = makeDropContainer;
  global.tdtEditor.insertWidgetHtml = insertWidgetHtml;

})(window);
/*
 * Minimal drag reordering for admin lists, built on pointer events (mouse, touch and pen).
 *
 * Markup:
 *   <ul data-sortable>                        container
 *     <li data-sortable-item>                 item (moves with its hidden order[] input)
 *       <button data-sortable-handle>         drag handle; arrow keys move the item
 *
 * Items keep their hidden inputs, so submitting the surrounding form sends the new order.
 * When the order changes, the container dispatches a bubbling "sortable:change" event.
 */

function items(container) {
    return [...container.querySelectorAll(':scope > [data-sortable-item]')];
}

function changed(container) {
    container.dispatchEvent(new CustomEvent('sortable:change', { bubbles: true }));
}

function move(container, item, delta) {
    const list = items(container);
    const target = list.indexOf(item) + delta;
    if (target < 0 || target >= list.length) {
        return false;
    }
    container.insertBefore(item, delta < 0 ? list[target] : list[target].nextSibling);
    return true;
}

function initSortable(container) {
    items(container).forEach((item) => {
        const handle = item.querySelector('[data-sortable-handle]');
        if (!handle) {
            return;
        }
        handle.style.touchAction = 'none';

        handle.addEventListener('pointerdown', (event) => {
            if (event.button !== 0) {
                return;
            }
            event.preventDefault();
            // Listen on window, not with pointer capture: re-inserting the item in the DOM drops capture
            item.classList.add('is-dragging');
            let moved = false;

            const onMove = (e) => {
                // Find the sibling under the pointer (the dragged item itself is ignored)
                const over = document.elementsFromPoint(e.clientX, e.clientY)
                    .map((el) => el.closest('[data-sortable-item]'))
                    .find((el) => el && el !== item && el.parentElement === container);
                if (!over) {
                    return;
                }
                const list = items(container);
                container.insertBefore(item, list.indexOf(item) < list.indexOf(over) ? over.nextSibling : over);
                moved = true;
            };
            const onEnd = (e) => {
                // The release point counts too: fast drags may report their last position only here
                if (e.type === 'pointerup') {
                    onMove(e);
                }
                window.removeEventListener('pointermove', onMove);
                window.removeEventListener('pointerup', onEnd);
                window.removeEventListener('pointercancel', onEnd);
                item.classList.remove('is-dragging');
                handle.focus();
                if (moved) {
                    changed(container);
                }
            };

            window.addEventListener('pointermove', onMove);
            window.addEventListener('pointerup', onEnd);
            window.addEventListener('pointercancel', onEnd);
        });

        // Keyboard: arrows move the focused handle's item one step
        handle.addEventListener('keydown', (event) => {
            const delta = { ArrowUp: -1, ArrowLeft: -1, ArrowDown: 1, ArrowRight: 1 }[event.key];
            if (!delta) {
                return;
            }
            event.preventDefault();
            if (move(container, item, delta)) {
                handle.focus();
                changed(container);
            }
        });
    });
}

document.querySelectorAll('[data-sortable]').forEach(initSortable);

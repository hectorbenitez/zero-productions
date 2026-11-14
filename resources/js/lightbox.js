// Full-screen image viewer for event galleries (Alpine component).
// Usage: x-data="lightbox([{ src, alt }, ...])" and @click.prevent="open(index)" on each thumbnail link.
// Links keep their href, so without JS they still open the image.
export default (items = []) => ({
    items,
    index: 0,
    isOpen: false,
    touchX: null,
    trigger: null,

    get current() {
        return this.items[this.index] ?? {};
    },

    get counter() {
        const pad = (n) => String(n).padStart(2, '0');
        return `${pad(this.index + 1)} / ${pad(this.items.length)}`;
    },

    open(i) {
        this.trigger = document.activeElement;
        this.index = i;
        this.isOpen = true;
        document.documentElement.style.overflow = 'hidden';
        this.preload();
        this.$nextTick(() => this.$refs.close?.focus());
    },

    close() {
        this.isOpen = false;
        document.documentElement.style.overflow = '';
        this.trigger?.focus?.();
    },

    next() {
        if (this.items.length < 2) return;
        this.index = (this.index + 1) % this.items.length;
        this.preload();
    },

    prev() {
        if (this.items.length < 2) return;
        this.index = (this.index - 1 + this.items.length) % this.items.length;
        this.preload();
    },

    preload() {
        [1, -1].forEach((step) => {
            const item = this.items[(this.index + step + this.items.length) % this.items.length];
            if (item) new Image().src = item.src;
        });
    },

    onKey(e) {
        if (!this.isOpen) return;
        if (e.key === 'Escape') this.close();
        else if (e.key === 'ArrowRight') this.next();
        else if (e.key === 'ArrowLeft') this.prev();
        else if (e.key === 'Tab') {
            // Keep focus inside the viewer
            const focusable = [...this.$refs.dialog.querySelectorAll('button')].filter((b) => b.offsetParent);
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    },

    touchStart(e) {
        this.touchX = e.changedTouches[0].clientX;
    },

    touchEnd(e) {
        if (this.touchX === null) return;
        const dx = e.changedTouches[0].clientX - this.touchX;
        this.touchX = null;
        if (Math.abs(dx) > 50) (dx < 0 ? this.next() : this.prev());
    },
});

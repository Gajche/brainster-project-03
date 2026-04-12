// resources/js/slider.js

document.addEventListener("alpine:init", () => {
    Alpine.data("eventSlider", () => ({
        active: 0,
        total: 3, // Number of items in @foreach

        next() {
            this.active = (this.active + 1) % this.total;
        },

        prev() {
            this.active = (this.active - 1 + this.total) % this.total;
        },

        getCardClass(index) {
            if (index === this.active) {
                return "active";
            }
            // Logic for the first peeking card (next in line)
            if (index === (this.active + 1) % this.total) {
                return "prev-stack";
            }
            // Logic for the second peeking card
            if (index === (this.active + 2) % this.total) {
                return "back-stack";
            }
            return "";
        },
    }));
});

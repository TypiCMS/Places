declare var google: any;

export default () => {
    return class Popup extends google.maps.OverlayView {
        position: google.maps.LatLng;
        containerDiv: HTMLDivElement;

        constructor(position: google.maps.LatLng, content: HTMLElement) {
            super();
            this.position = position;

            content.classList.add('popup-bubble');

            // This zero-height div is positioned at the bottom of the bubble.
            const bubbleAnchor = document.createElement('div');

            bubbleAnchor.classList.add('popup-bubble-anchor');
            bubbleAnchor.appendChild(content);

            // Close button
            const close = document.createElement('button');
            close.classList.add('popup-bubble-close');
            close.addEventListener('click', () => {
                this.setMap(null);
            });
            close.innerText = 'Close';
            content.appendChild(close);

            // This zero-height div is positioned at the bottom of the tip.
            this.containerDiv = document.createElement('div');
            this.containerDiv.classList.add('popup-container');
            this.containerDiv.appendChild(bubbleAnchor);

            // Optionally stop clicks, etc., from bubbling up to the map.
            Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
            // This handler allows right click events on anchor tags within the popup
            var allowAnchorRightClicksHandler = function (event) {
                event.cancelBubble = true;
                if (event.stopPropagation) {
                    event.stopPropagation();
                }
            };
            this.containerDiv.addEventListener('contextmenu', allowAnchorRightClicksHandler);
        }

        /** Called when the popup is added to the map. */
        onAdd() {
            this.getPanes()!.floatPane.appendChild(this.containerDiv);
        }

        /** Called when the popup is removed from the map. */
        onRemove() {
            if (this.containerDiv.parentElement) {
                this.containerDiv.parentElement.removeChild(this.containerDiv);
            }
        }

        /** Called each frame when the popup needs to draw itself. */
        draw() {
            const divPosition = this.getProjection().fromLatLngToDivPixel(this.position)!;

            // Hide the popup when it is far out of view.
            const display = Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ? 'block' : 'none';

            if (display === 'block') {
                this.containerDiv.style.left = divPosition.x + 'px';
                this.containerDiv.style.top = divPosition.y + 'px';
            }

            if (this.containerDiv.style.display !== display) {
                this.containerDiv.style.display = display;
            }
        }
    };
};

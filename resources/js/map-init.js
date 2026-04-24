// resources/js/map-init.js
import L from "leaflet";

// Fix for default marker icons with Vite
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: new URL(
        "leaflet/dist/images/marker-icon-2x.png",
        import.meta.url,
    ).href,
    iconUrl: new URL("leaflet/dist/images/marker-icon.png", import.meta.url)
        .href,
    shadowUrl: new URL("leaflet/dist/images/marker-shadow.png", import.meta.url)
        .href,
});

document.addEventListener("DOMContentLoaded", function () {
    const mapContainer = document.getElementById("map");
    const mapLabel = document.getElementById("map-label"); // Target the floating label

    if (mapContainer) {
        // 1. Initialize map
        const map = L.map("map", {
            scrollWheelZoom: false,
            dragging: !L.Browser.mobile,
            tap: !L.Browser.mobile,
        }).setView([41.4331, 22.0125], 13);

        // 2. Tile Layer (Voyager is cleaner for "Art" themes)
        L.tileLayer(
            "https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png",
            {
                attribution: "© OpenStreetMap contributors",
                subdomains: "abcd",
                maxZoom: 19,
            },
        ).addTo(map);

        // 3. Your Locations
        const locations = [
            {
                name: "Ул. „Франклин Рузвелт“ 44а, Скопје",
                coords: [41.9985, 21.4172],
                description: "2016 година",
            },

            {
                name: "Кинотека, Ул. „Никола Русински“ бр. 1, Скопје",
                coords: [42.0076, 21.4053],
                description: "2019 година",
            },

            {
                name: "Главна бина, Кавадарци",
                coords: [41.435, 22.01],
                description: "5-15 Август",
            },

            {
                name: "Парк Ѓорче Петров, Скопје",
                coords: [42.0078, 21.3636],
                description: "11-13 Септември",
            },
        ];

        const markerArray = [];

        // 4. Add markers to map
        locations.forEach((loc) => {
            const marker = L.marker(loc.coords).addTo(map);

            // Optional: Popup still works if someone clicks twice or wants detail
            marker.bindPopup(`
                <div class="p-1">
                    <strong class="text-ev-dark block border-b mb-1 uppercase">${loc.name}</strong>
                    <p class="text-sm text-gray-600 m-0">${loc.description}</p>
                </div>
            `);

            // DYNAMIC LABEL LOGIC
            marker.on("click", function () {
                if (mapLabel) {
                    // Small fade animation via JS (requires 'transition-all' on the HTML element)
                    mapLabel.style.opacity = "0";

                    setTimeout(() => {
                        mapLabel.innerHTML = `${loc.name}<br>${loc.description}`;
                        mapLabel.style.opacity = "1";
                    }, 150);
                }
            });

            markerArray.push(marker);
        });

        // 5. Reset label when clicking anywhere else on the map
        map.on("click", function () {
            if (mapLabel) {
                mapLabel.style.opacity = "0";
                setTimeout(() => {
                    mapLabel.innerHTML = `За детали,<br>одбери локација`;
                    mapLabel.style.opacity = "1";
                }, 150);
            }
        });

        // 6. SMART ZOOM (Fit all pins)
        if (markerArray.length > 0) {
            const group = new L.featureGroup(markerArray);
            // pad(0.2) gives 20% breathing room so pins aren't on the edge
            map.fitBounds(group.getBounds().pad(0.2));
        }

        // Final rendering fix for containers
        setTimeout(() => {
            map.invalidateSize();
        }, 200);
    }
});

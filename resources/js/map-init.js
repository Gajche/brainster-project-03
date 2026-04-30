import L from "leaflet";

// Fix for default marker icons when using Vite/ESBuild
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

document.addEventListener("DOMContentLoaded", () => {
    const mapContainer = document.getElementById("map");
    const mapLabel = document.getElementById("map-label");

    if (!mapContainer) return;

    // Define different tile layers
    const voyager = L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png",
        {
            attribution: "© OpenStreetMap contributors",
            subdomains: "abcd",
            maxZoom: 19,
        },
    );

    const darkMatter = L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png",
        {
            attribution: "© OpenStreetMap contributors, © CARTO",
            subdomains: "abcd",
            maxZoom: 19,
        },
    );

    const topoMap = L.tileLayer(
        "https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",
        {
            attribution:
                "© OpenStreetMap contributors, SRTM | Map style: © OpenTopoMap",
            maxZoom: 17,
        },
    );

    // Initialize the map
    const map = L.map("map", {
        scrollWheelZoom: false,
        dragging: !L.Browser.mobile,
        tap: !L.Browser.mobile,
        layers: [voyager], // voyager as default
    }).setView([41.4331, 22.0125], 13);

    // Group layers for the control UI
    const baseMaps = {
        Стандардна: voyager,
        Темна: darkMatter,
        Топографска: topoMap,
    };

    // Position set to 'bottomleft'
    L.control.layers(baseMaps, null, { position: "bottomleft" }).addTo(map);

    // List of locations
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

    // Helper to update the UI label
    const updateLabel = (content) => {
        if (!mapLabel) return;
        mapLabel.style.opacity = "0";
        setTimeout(() => {
            mapLabel.innerHTML = content;
            mapLabel.style.opacity = "1";
        }, 150);
    };

    // Create markers
    locations.forEach((loc) => {
        // Default icon but add a CSS class to turn it red via filters
        const marker = L.marker(loc.coords, {
            icon: new L.Icon.Default({ className: "red-pin" }),
        }).addTo(map);

        marker.on("click", () => {
            updateLabel(`${loc.name}<br>${loc.description}`);
        });

        markerArray.push(marker);
    });

    // Reset label on background click
    map.on("click", (e) => {
        if (e.originalEvent.target.id === "map") {
            updateLabel(`За детали,<br>одбери локација`);
        }
    });

    // Auto-fit bounds
    if (markerArray.length > 0) {
        const group = new L.featureGroup(markerArray);
        map.fitBounds(group.getBounds().pad(0.2));
    }

    // Refresh layout to fix container rendering
    setTimeout(() => {
        map.invalidateSize();
    }, 200);
});

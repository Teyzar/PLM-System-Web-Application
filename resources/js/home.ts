import axios from "axios";
import Echo from "laravel-echo";
import { Loader } from "@googlemaps/js-api-loader";

type HeatmapData = {
    id: string;
    active: boolean;
    latitude: number;
    longitude: number;
};

type WeightedLocationWithId = google.maps.visualization.WeightedLocation & {
    id: string;
};

let map: google.maps.Map;
let heatmap: google.maps.visualization.HeatmapLayer;
let heatmapData: google.maps.MVCArray<WeightedLocationWithId>;

const cadizCity: google.maps.LatLngLiteral = {
    lat: 10.94463755493866,
    lng: 123.27352044217186,
};

const loader = new Loader({
    apiKey: "AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU",
    version: "weekly",
    libraries: ["visualization"],
});

loader.load().then(async (google) => {
    // Initialize map
    map = new google.maps.Map(document.getElementById("map") as HTMLElement, {
        zoom: 13,
        center: cadizCity,
        mapTypeId: "roadmap",
    });

    // Initialize heatmap data
    heatmapData = new google.maps.MVCArray();

    // Initialize heatmap layer
    heatmap = new google.maps.visualization.HeatmapLayer({
        data: heatmapData,
        radius: 12,
    });

    // Link heatmap with map
    heatmap.setMap(map);

    // Get intial heatmap data from the api
    const response = await axios.get("/heatmap-data");
    const result: HeatmapData[] = response?.data ?? [];

    // Push all the data
    for (const data of result) {
        if (!data.active) continue;

        heatmapData.push({
            id: data.id,
            weight: 1,
            location: new google.maps.LatLng(data.latitude, data.longitude),
        });
    }

    // Setup websocket
    const echo = new Echo({
        broadcaster: "pusher",
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: process.env.MIX_APP_DEBUG ? false : true,
        forceTLS: process.env.MIX_APP_DEBUG ? false : undefined,
        wsPort: process.env.MIX_APP_DEBUG ? 6001 : undefined,
        wsHost: process.env.MIX_APP_DEBUG
            ? window.location.hostname
            : undefined,
    });

    // Listen to heatmap updates
    echo.channel("Heatmap").listen("HeatmapUpdate", updateHeatmap);
});

async function updateHeatmap(data: HeatmapData) {
    if (data.active) {
        // Construct the data
        const value = {
            id: data.id,
            weight: 1,
            location: new google.maps.LatLng(data.latitude, data.longitude),
        };

        // Get the current index if existing
        let currentIndex;
        for (let i = 0; i < heatmapData.getLength(); i++) {
            const thisData = heatmapData.getAt(i);
            if (thisData.id === data.id) {
                currentIndex = i;
                break;
            }
        }

        // Remove existing data
        if (typeof currentIndex === "number") {
            heatmapData.removeAt(currentIndex);
        }

        // Push the new data
        heatmapData.push(value);
    } else {
        // Loop through all the elements
        for (let i = 0; i < heatmapData.getLength(); i++) {
            const thisData = heatmapData.getAt(i);

            // Remove element if the phone number matches
            if (thisData.id === data.id) {
                heatmapData.removeAt(i);
                break;
            }
        }
    }
}

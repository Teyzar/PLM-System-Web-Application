import { Loader } from "@googlemaps/js-api-loader";
import axios from "axios";

let map: google.maps.Map;
let heatmap: google.maps.visualization.HeatmapLayer;
let heatmapData: google.maps.visualization.WeightedLocation[] = [];

interface HeatmapData {
    id: string;
    latitude: number;
    longitude: number;
    phone_number: string;
    created_at: string;
    updated_at: string;
}

const loader = new Loader({
    apiKey: "AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU",
    version: "weekly",
    libraries: ["visualization"],
});

const cadizCity: google.maps.LatLngLiteral = {
    lat: 10.94463755493866,
    lng: 123.27352044217186,
};

loader.load().then(async () => {
    map = new google.maps.Map(document.getElementById("map") as HTMLElement, {
        zoom: 13,
        center: cadizCity,
        mapTypeId: "roadmap",
    });

    // Get intial heatmap data from the api
    const response = await axios.get("/api/heatmap");
    const result: HeatmapData[] = response?.data ?? [];

    for (const data of result) {
        const location = new google.maps.LatLng(data.latitude, data.longitude);
        heatmapData.push({ location, weight: 1 });
    }

    heatmap = new google.maps.visualization.HeatmapLayer({
        map: map,
        data: heatmapData,
        radius: 12,
    });
});

import { Loader } from "@googlemaps/js-api-loader";

let map: google.maps.Map;

const loader = new Loader({
    apiKey: "AIzaSyA2vqdxEToK1qKnxm14YrCwJ1xoLd1FcBU",
    version: "weekly",
});

const cadizCity: google.maps.LatLngLiteral = {
    lat: 10.94463755493866,
    lng: 123.27352044217186,
};

loader.load().then(() => {
    map = new google.maps.Map(document.getElementById("map") as HTMLElement, {
        center: cadizCity,
        zoom: 13,
    });
});

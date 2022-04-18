let darkMode = localStorage.getItem('darkMode');
const darkModeButton = document.querySelector('#dark-mode-check');
const lightModeButton = document.querySelector('#light-mode-check');

const mapDark = [
    {
        elementType: "geometry",
        stylers: [{
            color: "#242f3e"
        }]
    },
    {
        elementType: "labels.text.stroke",
        stylers: [{
            color: "#242f3e"
        }]
    },
    {
        elementType: "labels.text.fill",
        stylers: [{
            color: "#746855"
        }]
    },
    {
        featureType: "administrative.locality",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#d59563"
        }],
    },
    {
        featureType: "poi",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#d59563"
        }],
    },
    {
        featureType: "poi.park",
        elementType: "geometry",
        stylers: [{
            color: "#263c3f"
        }],
    },
    {
        featureType: "poi.park",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#6b9a76"
        }],
    },
    {
        featureType: "road",
        elementType: "geometry",
        stylers: [{
            color: "#38414e"
        }],
    },
    {
        featureType: "road",
        elementType: "geometry.stroke",
        stylers: [{
            color: "#212a37"
        }],
    },
    {
        featureType: "road",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#9ca5b3"
        }],
    },
    {
        featureType: "road.highway",
        elementType: "geometry",
        stylers: [{
            color: "#746855"
        }],
    },
    {
        featureType: "road.highway",
        elementType: "geometry.stroke",
        stylers: [{
            color: "#1f2835"
        }],
    },
    {
        featureType: "road.highway",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#f3d19c"
        }],
    },
    {
        featureType: "transit",
        elementType: "geometry",
        stylers: [{
            color: "#2f3948"
        }],
    },
    {
        featureType: "transit.station",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#d59563"
        }],
    },
    {
        featureType: "water",
        elementType: "geometry",
        stylers: [{
            color: "#17263c"
        }],
    },
    {
        featureType: "water",
        elementType: "labels.text.fill",
        stylers: [{
            color: "#515c6d"
        }],
    },
    {
        featureType: "water",
        elementType: "labels.text.stroke",
        stylers: [{
            color: "#17263c"
        }],
    },
];

const mapLight = [];

const body = document.querySelector('body');

const enableDarkmode = () => {
    body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}}');
    if (typeof map !== "undefined") map.setOptions({ styles: mapDark });

    localStorage.setItem('darkMode', "enabled");
}

const enableLightMode = () => {
    body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light"}}');
    if (typeof map !== "undefined") map.setOptions({ styles: mapLight });

    localStorage.setItem('darkMode', "disabled");
}

if (darkMode === "enabled") {
    enableDarkmode();
}

darkModeButton.addEventListener('click', () => {
    darkMode = localStorage.getItem("darkMode");
    if (darkMode !== "enabled") {
        enableDarkmode();
    }
});
lightModeButton.addEventListener('click', () => {
    darkMode = localStorage.getItem("darkMode");
    if (darkMode == "enabled") {
        enableLightMode();
    }
});


//condensed Button

const condensedBtn = document.querySelector('#condensed-check');
const defaultBtn = document.querySelector('#default-size-check');

let condensed = localStorage.getItem('condensed');

const enableCondensed = () => {
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed"}, "width": "fluid"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "condensed"}, "width": "fluid"}');
    }
    localStorage.setItem('condensed', 'enabled');
}

const enableDefault = () => {
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "fluid"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "default"}, "width": "fluid"}');
    }
    localStorage.setItem('condensed', 'disabled');
}

if (condensed == "enabled") {
    enableCondensed();
}
condensedBtn.addEventListener('click', () => {
    condensed = localStorage.getItem('condensed');

    if (condensed !== "enabled") {
        enableCondensed();
    }
})
defaultBtn.addEventListener('click', () => {
    condensed = localStorage.getItem('condensed');
    if (condensed == "enabled") {
        enableDefault();
    }
});


const resetBtn = document.querySelector('#resetBtn');

resetBtn.addEventListener('click', () => {

    body.setAttribute('data-layout', '');
    localStorage.setItem('darkMode', "disabled");
    localStorage.setItem('condensed', "disabled");
});

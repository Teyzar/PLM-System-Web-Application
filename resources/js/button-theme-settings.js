let darkMode = localStorage.getItem('darkMode');
const darkModeButton = document.querySelector('#dark-mode-check');
const lightModeButton = document.querySelector('#light-mode-check');

const body = document.querySelector('body');

const enableDarkmode = () => {
    body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}}');

    localStorage.setItem('darkMode', "enabled");
}

const enableLightMode = () => {
    body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light"}}');
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

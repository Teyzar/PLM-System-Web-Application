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
    if (darkMode == "enabled" && boxWidth == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed"}, "width": "boxed"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "condensed"}, "width": "fluid"}');
    }
    if (darkMode == "enabled" && boxWidth == "disabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed"}, "width": "fluid"}');
    }
    if (darkMode == "disabled" && boxWidth == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "condensed"}, "width": "boxed"}');
    }
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed"}, "width": "fluid"}');
    }
    localStorage.setItem('condensed', 'enabled');
}

const enableDefault = () => {
    if (darkMode == "enabled" && boxWidth == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "boxed"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "default"}, "width": "fluid"}');
    }
    if (darkMode == "enabled" && boxWidth == "disabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "fluid"}');
    }
    if (darkMode == "disabled" && boxWidth == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "default"}, "width": "boxed"}');
    }
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "fluid"}');
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


//width size layout
let boxWidth = localStorage.getItem("boxedWidth")

const boxedWidthBtn = document.querySelector('#boxed-check');
const fluidWidthBtn = document.querySelector('#fluid-check');


const enableBoxWidth = () => {
    if (condensed == "enabled" && darkMode =="disabled") {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "default" }, "width": "boxed"}');
    }
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}, "width": "boxed"}');
    } else if (darkMode == "enabled" && condensed == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed" }, "width": "boxed"}');
    } else if (darkMode == "disabled" && condensed == "enabled"){
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "condensed"}, "width": "boxed"}');
    } else if (darkMode == "enabled" && condensed == "disabled"){
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "boxed"}');
    }
    localStorage.setItem('boxedWidth', "enabled");
}

const enableFluidWidth = () => {
    if (condensed == "enabled" && darkMode =="disabled") {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "default" }, "width": "fluid"}');
    }
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}, "width": "fluid"}');
    } else if (darkMode == "enabled" && condensed == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "condensed" }, "width": "fluid"}');
    } else if (darkMode == "disabled" && condensed == "enabled"){
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light", "size" : "condensed"}, "width": "fluid"}');
    } else if (darkMode == "enabled" && condensed == "disabled"){
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark", "size" : "default"}, "width": "fluid"}');
    }
    localStorage.setItem('boxedWidth', "disabled");
}

if (boxWidth == "enabled") {
    enableBoxWidth();
}

boxedWidthBtn.addEventListener('click', () => {
    boxWidth = localStorage.getItem('boxedWidth');
    if (boxWidth !== "enabled") {
        enableBoxWidth();
    }
});
fluidWidthBtn.addEventListener('click', () => {
    boxWidth = localStorage.getItem('boxedWidth');
    if (boxWidth == "enabled") {
        enableFluidWidth();
    }
});


// const resetBtn = document.querySelector('#resetBtn');

// resetBtn.addEventListener('click', () => {

//     body.setAttribute('data-layout', '{"mode": "light", "sidebar" : {"color" : "light", size : "default"}, "width" : "fluid"}');
//     localStorage.setItem('boxedWidth', "disabled");
//     localStorage.setItem('darkMode', "disabled");
//     localStorage.setItem('condensed', "disabled");
// });







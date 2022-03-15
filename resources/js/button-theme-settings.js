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

const resetBtn = document.querySelector('#resetBtn');
let boxWidth = localStorage.getItem("boxedWidth")

const boxedWidthBtn = document.querySelector('#boxed-check');
const fluidWidthBtn = document.querySelector('#fluid-check');




const enableBoxWidth = () => {
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}, "width": "boxed"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light"}, "width": "boxed"}');
    }
    localStorage.setItem('boxedWidth', "enabled");
}

const enableFluidWidth = () => {
    if (darkMode == "enabled") {
        body.setAttribute('data-layout', '{"mode" : "dark", "sidebar" : {"color" : "dark"}, "width": "fluid"}');
    } else {
        body.setAttribute('data-layout', '{"mode" : "light", "sidebar" : {"color" : "light"}, "width": "fluid"}');
    }
    localStorage.setItem('boxedWidth', "disabled");
}

if (boxWidth === "enabled") {
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


resetBtn.addEventListener('click', () => {
    darkMode = localStorage.getItem("darkMode");
    if (darkMode == "enabled") {
        enableLightMode();
    }
});




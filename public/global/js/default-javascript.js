export const defaultJavaScript = {

    main: function () {
        console.log("Running defaultJavaScript.run()");
        this.attachEvents();


    },

    attachEvents: function () {

        // header
        this.elements.header.pageLogo.addEventListener("click", () => {
            console.log("Clicked header");
            location.href = `${location.protocol}//${location.hostname}/home`
        })

        this.elements.header.basketBtn.addEventListener("click", () => {
            console.log("Clicked basket");
            location.href = `${location.protocol}//${location.hostname}/basket`
        });
    },

    apiData: {
        session: null,
        products: null
    },

    elements: {

        header: {
            pageLogo: document.getElementById('header-logo'),
            basketBtn: document.getElementById('header-basket-pill'),
            basketBtnText: document.getElementById('header-basket-pill-text')
        },

        footer: {

        }
    }
}

import SessionService from "./services/session-service.js";

export const defaultJavaScript = {

    initPage: function () {},

    runDefaultPageScript: async function () {
        console.log("Running defaultJavaScript.run()")
        this.attachEvents()
        this.updatePage()
        this.createUpdateOrderIfNotExist()
        this.apiData.updateOrder = sessionStorage.getItem('update_order')

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


    updatePage: async function () {
        console.log("Updating page");
        const session = await SessionService.getSession()
        this.elements.header.basketBtnText.innerHTML = `Indkøbskurv(${session.order.items.length})`;
    },

    createUpdateOrderIfNotExist: function () {
        const PRODUCT_PK_OF_NOVEL = 3
        const PRODUCT_PK_OF_CAREER = 4

        if(sessionStorage.getItem('update_order') !== null) return

        console.log("'update_order' does not exist")
        console.log("creating 'update_order'");

        sessionStorage.setItem('update_order', JSON.stringify([
        {
            product_pk: PRODUCT_PK_OF_NOVEL,
            quantity: 0
        },
        {
            product_pk: PRODUCT_PK_OF_CAREER,
            quantity: 0
        }
        ]));



    },





    apiData: {
        session: null,
        products: null,
        updateOrder: null,
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

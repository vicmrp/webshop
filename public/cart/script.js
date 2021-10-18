// Hvad skal den indenholde 


let y = ` {
    "customer": {
        "fullname": null,
        "address": {
            "street": null,
            "postal_code": null,
            "city": null
        },
        "contact": {
            "phone": null,
            "email": null
        },
        "company": {
            "cvr_number": null,
            "company_name": null
        }
    },
    "order": {
        "order_id": 3598943,
        "order_status": {
            "payment": {
                "accepted": false,
                "currency": "DKK",
                "amount": 31760
            },
            "email": {
                "confirmation_sent": false,
                "invoice_sent": false
            }
        },
        "order_item": [
            {
                "product_name": "cat6 UTP Dataudtag RJ45 1-stik - Hvid",
                "product_id": "77632",
                "price": 2320,
                "quantity": 6
            },
            {
                "product_name": "cat 5e U\/UTP Netv\u00e6rkskabel samler.",
                "product_id": "CCGP89005WT",
                "price": 960,
                "quantity": 4
            },
            {
                "product_name": "kabelsamler",
                "product_id": "2312314",
                "price": 1000,
                "quantity": 14
            }
        ]
    },
    "shipment": {
        "tracking_number": null,
        "order_collected": false,
        "address": {
            "street_name": null,
            "street_number": null,
            "postal_code": null,
            "city": null
        }
    }
}
`;

// Create Session-cart
// Read from Session-cart
// Update Session-cart
// Delete Session-cart

// sammenlign Session-cart med produktor



let cart  = {
    item1: 1,
    item2: 2,
}


let x = JSON.stringify(cart)

// Saves permanent 
localStorage.setItem('myCat', x);
localStorage.setItem('cart', y);


const cat = localStorage.getItem('myCat');


console.log(cat)
const searchInput =
    document.getElementById("menuSearch");

const menuCards =
    document.querySelectorAll(".menu-card");

const cartButton =
    document.getElementById("cartButton");

const cartOverlay =
    document.getElementById("cartOverlay");

const closeCart =
    document.getElementById("closeCart");

const cartItems =
    document.getElementById("cartItems");

const cartCount =
    document.getElementById("cartCount");

const cartTotal =
    document.getElementById("cartTotal");


let cart = [];


/* ==============================
   SEARCH
============================== */

searchInput.addEventListener("input", function () {

    const search =
        this.value.toLowerCase().trim();


    menuCards.forEach(function (card) {

        const name =
            card.dataset.name.toLowerCase();


        if (name.includes(search)) {

            card.style.display = "block";

            card.classList.add("search-hit");

        } else {

            card.style.display = "none";

        }

    });

});


/* ==============================
   ADD TO CART
============================== */

document
    .querySelectorAll(".add-cart")
    .forEach(function (button) {


        button.addEventListener(
            "click",
            function () {


                const name =
                    this.dataset.name;

                const price =
                    Number(this.dataset.price);


                cart.push({

                    name: name,

                    price: price

                });


                updateCart();


                cartOverlay.classList.add(
                    "active"
                );


            }
        );

    });


/* ==============================
   UPDATE CART
============================== */

function updateCart() {


    cartCount.textContent =
        cart.length;


    if (cart.length === 0) {

        cartItems.innerHTML = `

            <div class="empty-cart">

                Your cart is waiting
                for something delicious. ☕

            </div>

        `;

        cartTotal.textContent = "₹0";

        return;

    }


    cartItems.innerHTML = "";


    let total = 0;


    cart.forEach(function (item, index) {


        total += item.price;


        const row =
            document.createElement("div");


        row.className =
            "cart-row";


        row.innerHTML = `

            <div>

                <strong>
                    ${item.name}
                </strong>

                <br>

                <small>
                    ₹${item.price}
                </small>

            </div>


            <button
                class="remove-item"
                data-index="${index}"
            >
                ×
            </button>

        `;


        cartItems.appendChild(row);

    });


    cartTotal.textContent =
        "₹" + total;


    document
        .querySelectorAll(".remove-item")
        .forEach(function (button) {


            button.addEventListener(
                "click",
                function () {

                    const index =
                        Number(
                            this.dataset.index
                        );


                    cart.splice(index, 1);


                    updateCart();

                }
            );

        });

}


/* ==============================
   OPEN CART
============================== */

cartButton.addEventListener(
    "click",
    function () {

        cartOverlay.classList.add(
            "active"
        );

    }
);


/* ==============================
   CLOSE CART
============================== */

closeCart.addEventListener(
    "click",
    function () {

        cartOverlay.classList.remove(
            "active"
        );

    }
);


/* Click outside cart */

cartOverlay.addEventListener(
    "click",
    function (event) {

        if (
            event.target === cartOverlay
        ) {

            cartOverlay.classList.remove(
                "active"
            );

        }

    }
);
const inputs = document.querySelectorAll("input");

inputs.forEach(input => {
    input.addEventListener("change", calculatePrice);
});


function calculatePrice() {

    let total = 0;


    // Coffee Base
    const base = document.querySelector(
        'input[name="base"]:checked'
    );

    if (base) {
        total += Number(base.value);
    }


    // Flavour
    const flavour = document.querySelector(
        'input[name="flavour"]:checked'
    );

    if (flavour) {
        total += Number(flavour.value);
    }


    // Toppings
    const toppings = document.querySelectorAll(
        'input[name="topping"]:checked'
    );

    toppings.forEach(item => {
        total += Number(item.value);
    });


    // Extras
    const extras = document.querySelectorAll(
        'input[name="extra"]:checked'
    );

    extras.forEach(item => {
        total += Number(item.value);
    });


    // Premium Snacks
    const snacks = document.querySelectorAll(
        'input[name="snack"]:checked'
    );

    snacks.forEach(item => {
        total += Number(item.value);
    });


    // Total Price
    document.getElementById("totalPrice").innerText =
        "₹" + total;


    // Coffee Name
    let coffeeName = base.dataset.name;

    if (flavour) {
        coffeeName += " with " + flavour.dataset.name;
    }

    document.getElementById("coffeeName").innerText =
        coffeeName;
}


function addToOrder() {

    const base = document.querySelector(
        'input[name="base"]:checked'
    );

    const total =
        document.getElementById("totalPrice").innerText;

    document.getElementById("message").innerText =
        "✓ " + base.dataset.name +
        " added to your order! Total: " + total;
}


calculatePrice();
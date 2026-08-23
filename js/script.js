document.addEventListener("DOMContentLoaded", () => {

    /* ================================
       MOBILE NAVIGATION
    ================================= */

    const menuToggle = document.querySelector(".menu-toggle");
    const navbar = document.querySelector(".navbar");

    if (menuToggle && navbar) {
        menuToggle.addEventListener("click", () => {
            navbar.classList.toggle("active");
            menuToggle.classList.toggle("active");
        });

        navbar.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                navbar.classList.remove("active");
                menuToggle.classList.remove("active");
            });
        });
    }


    /* ================================
       STICKY HEADER
    ================================= */

    const header = document.querySelector(".header");

    if (header) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    }


    /* ================================
       SMOOTH SCROLL
    ================================= */

    document.querySelectorAll('a[href^="#"]').forEach(link => {

        link.addEventListener("click", event => {

            const targetId = link.getAttribute("href");

            if (targetId === "#") return;

            const target = document.querySelector(targetId);

            if (target) {
                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });

    });


    /* ================================
       RESERVATION FORM
    ================================= */

    const reservationForm =
        document.querySelector("#reservationForm");

    if (reservationForm) {

        reservationForm.addEventListener("submit", event => {

            event.preventDefault();

            const name =
                reservationForm.querySelector('[name="name"]')?.value.trim();

            const email =
                reservationForm.querySelector('[name="email"]')?.value.trim();

            const date =
                reservationForm.querySelector('[name="date"]')?.value;

            const guests =
                reservationForm.querySelector('[name="guests"]')?.value;

            if (!name || !email || !date || !guests) {
                showMessage(
                    "Please fill in all required fields.",
                    "error"
                );
                return;
            }

            showMessage(
                `Thank you, ${name}! Your reservation request has been received.`,
                "success"
            );

            reservationForm.reset();
        });
    }


    /* ================================
       REVIEW FORM
    ================================= */

    const reviewForm =
        document.querySelector("#reviewForm");

    if (reviewForm) {

        reviewForm.addEventListener("submit", event => {

            event.preventDefault();

            const name =
                reviewForm.querySelector('[name="name"]')?.value.trim();

            const review =
                reviewForm.querySelector('[name="review"]')?.value.trim();

            if (!name || !review) {
                showMessage(
                    "Please enter your name and review.",
                    "error"
                );
                return;
            }

            showMessage(
                "Thank you for sharing your experience with Veloura!",
                "success"
            );

            reviewForm.reset();
        });
    }


    /* ================================
       IMAGE LAZY LOADING
    ================================= */

    document.querySelectorAll("img").forEach(image => {
        image.setAttribute("loading", "lazy");
    });


    /* ================================
       SCROLL REVEAL ANIMATION
    ================================= */

    const revealElements =
        document.querySelectorAll(
            ".offer-card, .service-card, .review-card, .menu-card, .gallery-item"
        );

    if (revealElements.length > 0) {

        const observer = new IntersectionObserver(
            entries => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                        observer.unobserve(entry.target);
                    }

                });

            },
            {
                threshold: 0.15
            }
        );

        revealElements.forEach(element => {
            observer.observe(element);
        });
    }


    /* ================================
       BACK TO TOP BUTTON
    ================================= */

    const backToTop =
        document.querySelector("#backToTop");

    if (backToTop) {

        window.addEventListener("scroll", () => {

            if (window.scrollY > 400) {
                backToTop.classList.add("show");
            } else {
                backToTop.classList.remove("show");
            }

        });

        backToTop.addEventListener("click", () => {

            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

        });
    }


    /* ================================
       HELPER FUNCTION
    ================================= */

    function showMessage(message, type) {

        let messageBox =
            document.querySelector(".js-message");

        if (!messageBox) {

            messageBox = document.createElement("div");

            messageBox.className = "js-message";

            document.body.appendChild(messageBox);
        }

        messageBox.textContent = message;

        messageBox.className =
            `js-message ${type}`;

        setTimeout(() => {
            messageBox.classList.remove("success", "error");
        }, 4000);
    }

});
document.addEventListener("DOMContentLoaded", () => {

    /* =========================
       APPARITION AU SCROLL
    ========================= */

    const elements = document.querySelectorAll(
        ".philosophie-content, " +
        ".philosophie-image, " +
        ".prestation-card, " +
        ".why-card, " +
        ".avis-card, " +
        ".final-content"
    );

    const observer = new IntersectionObserver(
        (entries) => {

            entries.forEach((entry) => {

                if (entry.isIntersecting) {

                    entry.target.classList.add("is-visible");

                    observer.unobserve(entry.target);
                }

            });

        },
        {
            threshold: 0.15
        }
    );

    elements.forEach((element) => {
        observer.observe(element);
    });


    /* =========================
       PARALLAX HERO
    ========================= */

    const hero = document.querySelector(".hero");

    if (hero) {

        window.addEventListener("scroll", () => {

            const scroll = window.scrollY;

            if (scroll < window.innerHeight) {

                hero.style.backgroundPosition =
                    `center ${scroll * 0.35}px`;

            }

        });

    }


    /* =========================
       EFFET 3D CARTES
    ========================= */

    const cards = document.querySelectorAll(
        ".prestation-card, .why-card"
    );

    cards.forEach((card) => {

        card.addEventListener("mousemove", (event) => {

            const rect = card.getBoundingClientRect();

            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX =
                ((y - centerY) / centerY) * -2;

            const rotateY =
                ((x - centerX) / centerX) * 2;

            card.style.transform =
                `translateY(-6px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

        });

        card.addEventListener("mouseleave", () => {

            card.style.transform =
                "translateY(0) rotateX(0) rotateY(0)";

        });

    });

});
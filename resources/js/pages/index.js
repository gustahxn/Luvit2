import "../../css/pages/index.css"; 

document.addEventListener("DOMContentLoaded", function () {

    const heroSplide = new Splide("#hero-splide", {
        type: "loop",
        autoplay: true,
        interval: 8000,
        pauseOnHover: false,
        arrows: true,
        pagination: true,
        speed: 1200,
        easing: "cubic-bezier(0.25, 1, 0.5, 1)",
        lazyLoad: "nearby",
        preloadPages: 2,
        breakpoints: {
            768: {
                arrows: false,
                pagination: true,
                interval: 6000,
            },
        },
    });

    const trendingSplide = new Splide("#trending-splide", {
        type: "loop",
        perPage: 6,
        perMove: 2,
        gap: "1.5rem",
        arrows: true,
        pagination: false,
        autoplay: true,
        interval: 4000,
        pauseOnHover: true,
        speed: 800,
        lazyLoad: "nearby",
        breakpoints: {
            1536: { perPage: 5, gap: "1.2rem" },
            1280: { perPage: 4, gap: "1rem" },
            1024: { perPage: 3, gap: "1rem" },
            768: {
                perPage: 2.2,
                gap: "0.8rem",
                arrows: false,
                pagination: true,
            },
            640: {
                perPage: 1.5,
                gap: "0.5rem",
                arrows: false,
                pagination: true,
            },
        },
    });

    heroSplide.mount();
    trendingSplide.mount();

    for (let i = 0; i < filmes.length; i++) {
        (function () {
            const el = document.getElementById("lottie-like-" + i);
            if (!el) return;

            lottie.loadAnimation({
                container: el,
                renderer: "svg",
                loop: true,
                autoplay: true,
                path: "https://lottie.host/4f0e75a9-4ba3-44ce-8065-b7b7d6e7b645/sJ9RHwO5vj.json",
            });
        })();
    }

    const watchlistBtn = document.getElementById("watchlistBtn");
    if (watchlistForm && watchlistBtn) {
        watchlistForm.addEventListener("submit", () => {
            setTimeout(() => {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    scalar: 0.9,
                    colors: ["#f43f5e", "#f97316", "#facc15"], // rosa, laranja, amarelo
                    origin: {
                        y: 0.2,
                        x:
                            watchlistBtn.getBoundingClientRect().left /
                            window.innerWidth,
                    },
                });
            }, 0);
        });
    }

    const backdrop = document.getElementById("hero-backdrop");
    if (backdrop) {
        heroSplide.on("move", function (newIndex) {
            const slide = heroSplide.Components.Elements.slides[newIndex];
            const newBackdrop = slide.dataset.backdrop;
            if (newBackdrop) {
                const img = new Image();
                img.onload = function () {
                    backdrop.style.opacity = "0.7";
                    setTimeout(() => {
                        backdrop.src =
                            "https://image.tmdb.org/t/p/original" + newBackdrop;
                        backdrop.style.opacity = "1";
                    }, 300);
                };
                img.src = "https://image.tmdb.org/t/p/original" + newBackdrop;
            }
        });
    }

    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);

    document
        .querySelectorAll(".poster-grid-item, .movie-card")
        .forEach((element, index) => {
            element.style.opacity = "0";
            element.style.transform = "translateY(30px)";
            element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
            element.style.transitionDelay = `${index * 0.1}s`;
            observer.observe(element);
        });

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });

    const images = document.querySelectorAll('img[loading="lazy"]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;

                img.classList.add("skeleton");

                img.addEventListener("load", () => {
                    img.classList.remove("skeleton");
                });

                img.addEventListener("error", () => {
                    img.classList.remove("skeleton");
                    img.style.display = "none";
                });

                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach((img) => imageObserver.observe(img));

    document.querySelectorAll(".movie-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.zIndex = "10";
        });

        card.addEventListener("mouseleave", function () {
            this.style.zIndex = "1";
        });
    });

    window.addEventListener("scroll", () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll(
            ".hero-section .absolute"
        );

        parallaxElements.forEach((element, index) => {
            const speed = 0.1 + index * 0.05;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });

    let currentHeroIndex = 0;
    const heroSlides = document.querySelectorAll("#hero-splide .splide__slide");

    function preloadNextHeroImage() {
        const nextIndex = (currentHeroIndex + 1) % heroSlides.length;
        const nextBackdrop = heroSlides[nextIndex].dataset.backdrop;

        if (nextBackdrop) {
            const img = new Image();
            img.src = "https://image.tmdb.org/t/p/original" + nextBackdrop;
        }
    }

    heroSplide.on("moved", function (newIndex) {
        currentHeroIndex = newIndex;
        preloadNextHeroImage();
    });

    preloadNextHeroImage();
});

if (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4) {
    document.documentElement.style.setProperty("--animation-duration", "0.2s");
}

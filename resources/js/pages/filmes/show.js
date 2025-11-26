import "../../../css/pages/filmes/show.css";

document.addEventListener("DOMContentLoaded", () => {

    gsap.from(".poster-frame", {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out",
    });
    gsap.from(".luv-card", {
        y: 30,
        opacity: 0,
        duration: 0.8,
        delay: 0.08,
        ease: "power2.out",
    });

    gsap.utils.toArray(".tag-first").forEach((el, i) => {
        gsap.from(el, {
            y: 16,
            opacity: 0,
            duration: 0.5,
            delay: 0.15 + i * 0.04,
            ease: "power2.out",
        });
    });

    document.querySelectorAll(".luv-btn").forEach((btn) => {
        btn.addEventListener("mousemove", (e) => {
            const r = btn.getBoundingClientRect();
            btn.style.setProperty("--x", e.clientX - r.left + "px");
            btn.style.setProperty("--y", e.clientY - r.top + "px");
        });
    });

    const poster = document.querySelector(".poster-image");
    const detailsContainer = document.querySelector(".luv-card");
    if (poster && detailsContainer && window.innerWidth >= 1024) {
        function adjustPosterHeight() {
            const detailsHeight = detailsContainer.offsetHeight + 140;
            const minHeight = 460;
            poster.style.height =
                detailsHeight > minHeight
                    ? `${detailsHeight}px`
                    : `${minHeight}px`;
        }
        setTimeout(adjustPosterHeight, 350);
        window.addEventListener("resize", adjustPosterHeight);
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    gsap.to(entry.target, {
                        y: 0,
                        opacity: 1,
                        duration: 0.5,
                        ease: "power2.out",
                    });
                    io.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 }
    );

    document.querySelectorAll(".review-card").forEach((el) => {
        gsap.set(el, { y: 20, opacity: 0 });
        io.observe(el);
    });

    const setupToggleAction = (formId, btnId, countClass, isLike = true) => {
        const actionForm = document.getElementById(formId);
        if (!actionForm) return;

        actionForm.addEventListener("submit", function (event) {
            event.preventDefault(); 

            const form = event.target;
            const actionBtn = document.getElementById(btnId);
            const countDisplay = document.querySelector(countClass);

            actionBtn.disabled = true;

            fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": form.querySelector('input[name="_token"]')
                        .value,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    actionBtn.disabled = false;

                    if (data.success) {
                        const isAdded = data.added;
                        const addedClass = isLike ? "liked" : "watchlisted";

                        if (isAdded) {
                            actionBtn.classList.add(addedClass);
                        } else {
                            actionBtn.classList.remove(addedClass);
                        }

                        if (isLike && countDisplay) {
                            countDisplay.textContent = `${data.count} Likes`;
                        }

                        if (
                            isLike &&
                            isAdded &&
                            typeof confetti === "function"
                        ) {
                            confetti({
                                particleCount: 100,
                                spread: 70,
                                origin: { y: 0.6 },
                            });
                        }
                    } else {
                        console.error(
                            "Erro na ação:",
                            data.message || "Erro desconhecido."
                        );
                        alert(
                            "Não foi possível completar a ação. Tente novamente."
                        );
                    }
                })
                .catch((error) => {
                    actionBtn.disabled = false;
                    console.error("Erro de rede/servidor:", error);
                    alert("Ocorreu um erro de comunicação com o servidor.");
                });
        });
    };

    setupToggleAction("likeForm", "likeBtn", ".like-count", true);
    setupToggleAction("watchlistForm", "watchlistBtn", null, false);

    window.scrollToReviews = function () {
        const reviewsSection = document.getElementById("reviews-section");
        if (reviewsSection) {
            reviewsSection.scrollIntoView({ behavior: "smooth" });
            setTimeout(() => {
                document.getElementById("review")?.focus();
            }, 500);
        }
    };

    window.toggleReplyForm = function (reviewId) {
        const form = document.getElementById(`reply-form-${reviewId}`);
        if (form) {
            form.classList.toggle("hidden");
        }
    };
});

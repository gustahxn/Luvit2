import "../../../css/pages/games/show.css";

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
    gsap.from("h1", {
        y: 20,
        opacity: 0,
        duration: 0.8,
        delay: 0.15,
        ease: "power2.out",
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

    window.scrollToReviews = function () {
        const reviewsSection = document.getElementById("reviews-section");
        if (reviewsSection) {
            reviewsSection.scrollIntoView({ behavior: "smooth" });
            setTimeout(() => {
                document.getElementById("review")?.focus();
            }, 500);
        }
    };

    const likeForm = document.getElementById("likeForm");
    const likeBtn = document.getElementById("likeBtn");
    const likeCountEl = document.querySelector(".like-count");

    if (likeForm && likeBtn && likeCountEl) {

        const likeSpanHTML = `<span class="absolute -z-10 inset-0 rounded-full" style="background: radial-gradient(120px 40px at 50% 50%, rgba(16,185,129,.15), transparent 40%);"></span>`;
        const filledHeartHTML = `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/></svg>${likeSpanHTML}`;
        const emptyHeartHTML = `<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"/></svg>${likeSpanHTML}`;

        likeForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            let currentLikes =
                parseInt(likeCountEl.textContent.replace(/\D/g, "")) || 0;

            const isNowLiked = !likeBtn.classList.contains("liked");
            likeBtn.classList.toggle("liked", isNowLiked);
            likeBtn.innerHTML = isNowLiked ? filledHeartHTML : emptyHeartHTML;

            likeCountEl.textContent = `${
                isNowLiked ? currentLikes + 1 : Math.max(0, currentLikes - 1)
            } Likes`;

            likeBtn.classList.add("animate-heart");
            setTimeout(() => likeBtn.classList.remove("animate-heart"), 600);

            if (typeof confetti !== "undefined" && isNowLiked) {
                confetti({
                    particleCount: 80,
                    spread: 60,
                    origin: { y: 0.6 },
                });
            }

            try {
                const formData = new FormData(likeForm);
                const res = await fetch(likeForm.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                });

                if (res.ok) {
                    const data = await res.json().catch(() => null);

                    if (data && typeof data.likeCount === "number") {
                        likeCountEl.textContent = `${data.likeCount} Likes`;

                        if (typeof data.isLiked === "boolean") {
                            likeBtn.classList.toggle("liked", data.isLiked);
                            likeBtn.innerHTML = data.isLiked
                                ? filledHeartHTML
                                : emptyHeartHTML;
                        }

                    }
                }
            } catch (err) {
                console.error("erro ao atualizar like:", err);
            }
        });
    }

    const watchlistForm = document.getElementById("watchlistForm");
    const watchlistBtn = document.getElementById("watchlistBtn");
    if (watchlistForm && watchlistBtn) {

        const bookmarkSpanHTML = `<span class="absolute -z-10 inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300" style="background: radial-gradient(120px 40px at 50% 50%, rgba(239,68,68,.25), transparent 40%);"></span>`;
        const filledBookmarkHTML = `<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M5 3a2 2 0 0 0-2 2v16l9-4 9 4V5a2 2 0 0 0-2-2H5z"/></svg>${bookmarkSpanHTML}`;
        const emptyBookmarkHTML = `<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3a2 2 0 0 0-2 2v16l9-4 9 4V5a2 2 0 0 0-2-2H5z"/></svg>${bookmarkSpanHTML}`;

        watchlistForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(watchlistForm);
            fetch(watchlistForm.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.inWatchlist) {
                        watchlistBtn.innerHTML = filledBookmarkHTML;
                        watchlistBtn.classList.add(
                            "watchlisted",
                            "animate-bookmark"
                        );
                    } else {
                        watchlistBtn.innerHTML = emptyBookmarkHTML; 
                        watchlistBtn.classList.remove("watchlisted");
                    }

                    setTimeout(
                        () => watchlistBtn.classList.remove("animate-bookmark"),
                        600
                    );
                })
                .catch(console.error);
        });
    }

    if (typeof gsap !== "undefined") {
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

        document.querySelectorAll(".review-item").forEach((el) => {
            gsap.set(el, { y: 20, opacity: 0 });
            io.observe(el);
        });
    }

});

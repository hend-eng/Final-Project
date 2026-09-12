document.addEventListener("DOMContentLoaded", () => {
  /*
   * =========================================================
   * HERO STATISTICS COUNTERS
   * =========================================================
   *
   * Animates:
   *
   * 200+     → 0 → 200+
   * 2,000+   → 0 → 2,000+
   * 30,000+  → 0 → 30,000+
   *
   * The animation starts when the statistics become visible.
   */

  const counters = document.querySelectorAll(".count-number");

  /*
   * Format numbers with commas.
   *
   * 2000  → 2,000
   * 30000 → 30,000
   */

  const formatNumber = (number) => {
    return number.toLocaleString("en-US");
  };

  /*
   * Put the final value into the counter.
   */

  const setFinalValue = (counter) => {
    const target = Number(counter.dataset.target);

    const suffix = counter.dataset.suffix || "";

    counter.textContent = `${formatNumber(target)}${suffix}`;
  };

  /*
   * Animate one counter.
   */

  const animateCounter = (counter) => {
    const target = Number(counter.dataset.target);

    const suffix = counter.dataset.suffix || "";

    const duration = 1800;

    const startTime = performance.now();

    const update = (currentTime) => {
      const elapsed = currentTime - startTime;

      const progress = Math.min(elapsed / duration, 1);

      /*
       * Ease-out animation.
       *
       * Starts quickly and slows down
       * as it approaches the final number.
       */

      const easedProgress = 1 - Math.pow(1 - progress, 3);

      const currentValue = Math.floor(target * easedProgress);

      counter.textContent = `${formatNumber(currentValue)}${suffix}`;

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        setFinalValue(counter);
      }
    };

    requestAnimationFrame(update);
  };

  /*
   * Start all counters.
   */

  const startCounters = () => {
    counters.forEach((counter) => {
      animateCounter(counter);
    });
  };

  /*
   * Only run the counter code if
   * counters actually exist on the page.
   */

  if (counters.length) {
    const stats = document.querySelector(".hero-stats");

    const reducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)",
    ).matches;

    /*
     * Accessibility:
     *
     * If the user prefers reduced motion,
     * immediately show the final values.
     */

    if (reducedMotion) {
      counters.forEach(setFinalValue);
    } else if (stats && "IntersectionObserver" in window) {
      /*
       * Use IntersectionObserver so the
       * animation starts when the statistics
       * become visible.
       */
      let started = false;

      const observer = new IntersectionObserver(
        (entries) => {
          if (started) {
            return;
          }

          const isVisible = entries.some((entry) => entry.isIntersecting);

          if (isVisible) {
            started = true;

            startCounters();

            observer.disconnect();
          }
        },

        {
          threshold: 0.25,
        },
      );

      observer.observe(stats);
    } else {
      /*
       * Fallback for older browsers.
       */
      startCounters();
    }
  }

  /*
   * =========================================================
   * DATABASE-DRIVEN BRANDS SLIDER
   * =========================================================
   *
   * The brands themselves come from the database.
   *
   * Current brand:
   *
   *       ← moves LEFT
   *
   * Next brand:
   *
   *                         enters from RIGHT →
   *
   * Then the process repeats forever.
   *
   * Example:
   *
   * VERSACE
   *     ←
   *
   *                 ZARA →
   *
   * ZARA
   *     ←
   *
   *                 GUCCI →
   *
   * GUCCI
   *     ←
   *
   *                 PRADA →
   *
   * etc.
   *
   * The number of brands doesn't matter.
   * If the database contains 5 brands,
   * it loops through 5.
   *
   * If it contains 20 brands,
   * it loops through all 20.
   */

  const brandSlides = document.querySelectorAll(".home-brand-slide");

  /*
   * We only need the slider logic if
   * there are at least two brands.
   */

  if (brandSlides.length > 1) {
    /*
     * Keep track of the currently visible brand.
     *
     * 0 = first brand
     * 1 = second brand
     * 2 = third brand
     * etc.
     */

    let currentIndex = 0;

    /*
     * Stores the automatic slider timer.
     */

    let timer = null;

    /*
     * Prevent two animations from
     * running at the same time.
     */

    let isAnimating = false;

    /*
     * Respect the user's reduced-motion
     * accessibility setting.
     */

    const reducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)",
    ).matches;

    /*
     * =====================================================
     * MOVE TO NEXT BRAND
     * =====================================================
     */

    const moveToNextBrand = () => {
      /*
       * Don't start another animation
       * while one is already running.
       */

      if (isAnimating) {
        return;
      }

      isAnimating = true;

      /*
       * Current brand.
       */

      const currentSlide = brandSlides[currentIndex];

      /*
       * Calculate the next brand.
       *
       * The % makes the slider loop:
       *
       * 0 → 1 → 2 → 3 → 4 → 0
       */

      const nextIndex = (currentIndex + 1) % brandSlides.length;

      /*
       * Next brand.
       */

      const nextSlide = brandSlides[nextIndex];

      /*
       * =================================================
       * PREPARE NEXT BRAND
       * =================================================
       *
       * Put the next brand on the RIGHT side
       * of the screen.
       */

      nextSlide.classList.remove("active", "exit-left");

      nextSlide.classList.add("enter-right");

      /*
       * =================================================
       * MOVE CURRENT BRAND LEFT
       * =================================================
       */

      currentSlide.classList.remove("active", "enter-right");

      currentSlide.classList.add("exit-left");

      /*
       * =================================================
       * FINISH ANIMATION
       * =================================================
       *
       * CSS animation duration:
       * approximately 700ms.
       */

      window.setTimeout(
        () => {
          /*
           * Remove old brand animation.
           */

          currentSlide.classList.remove("exit-left");

          /*
           * Clear any inline styles
           * that might remain.
           */

          currentSlide.style.opacity = "";

          currentSlide.style.visibility = "";

          /*
           * Make the new brand the
           * active brand.
           */

          nextSlide.classList.remove("enter-right");

          nextSlide.classList.add("active");

          /*
           * Update current index.
           */

          currentIndex = nextIndex;

          /*
           * Allow another animation.
           */

          isAnimating = false;
        },
        reducedMotion ? 0 : 700,
      );
    };

    /*
     * =====================================================
     * START SLIDER
     * =====================================================
     */

    if (reducedMotion) {
      /*
       * If reduced motion is enabled,
       * keep only the first brand visible.
       */

      brandSlides.forEach((slide, index) => {
        slide.classList.toggle("active", index === 0);
      });
    } else {
      /*
       * Change brand every 2.5 seconds.
       */

      timer = window.setInterval(moveToNextBrand, 2500);
    }

    /*
     * =====================================================
     * PAUSE WHEN TAB IS HIDDEN
     * =====================================================
     *
     * This prevents the slider from continuing
     * unnecessarily when the user changes tabs.
     */

    document.addEventListener("visibilitychange", () => {
      /*
       * User left the tab.
       */

      if (document.hidden) {
        if (timer) {
          window.clearInterval(timer);

          timer = null;
        }
      } else if (!reducedMotion && !timer) {
        /*
         * User returned to the tab.
         */
        timer = window.setInterval(moveToNextBrand, 2500);
      }
    });
  }
});
/*
 * =========================================================
 * PROMO BAR CLOSE BUTTON
 * =========================================================
 */

const promoBar = document.getElementById("promoBar");

const promoClose = document.getElementById("promoClose");

if (promoBar && promoClose) {
  promoClose.addEventListener("click", function (event) {
    event.preventDefault();

    promoBar.remove();
  });
}

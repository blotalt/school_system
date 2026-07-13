//
// ==============================
// School Management Dashboard
// script.js
// ==============================

document.addEventListener("DOMContentLoaded", () => {

    console.log("Dashboard Loaded");

    // ==========================
    // Sidebar Active Menu
    // ==========================

    const menuLinks = document.querySelectorAll(".menu a");

    menuLinks.forEach(link => {

        link.addEventListener("click", function () {

            menuLinks.forEach(item => item.classList.remove("active"));

            this.classList.add("active");

        });

    });

    // ==========================
    // Search
    // ==========================

    const searchInput = document.querySelector(".search-box input");

    if (searchInput) {

        searchInput.addEventListener("keyup", function () {

            console.log("Searching:", this.value);

        });

    }

    // ==========================
    // Notification
    // ==========================

    const notification = document.querySelector(".notification");

    if (notification) {

        notification.addEventListener("click", () => {

            alert("No new notifications.");

        });

    }

    // ==========================
    // Publish Button
    // ==========================

    const publishBtn = document.querySelector(".publish-btn");

    if (publishBtn) {

        publishBtn.addEventListener("click", () => {

            alert("Timetable published successfully!");

        });

    }

    // ==========================
    // Subject Card Selection
    // ==========================

    const cards = document.querySelectorAll(".subject-card");

    cards.forEach(card => {

        card.addEventListener("click", () => {

            cards.forEach(c => c.classList.remove("selected"));

            card.classList.add("selected");

        });

    });

    // ==========================
    // Dropdown
    // ==========================

    const select = document.querySelector("select");

    if (select) {

        select.addEventListener("change", () => {

            console.log("Selected:", select.value);

        });

    }

    // ==========================
    // Today's Schedule Hover
    // ==========================

    const schedule = document.querySelectorAll(".schedule-item");

    schedule.forEach(item => {

        item.addEventListener("mouseenter", () => {

            item.style.background = "#f7fbff";

        });

        item.addEventListener("mouseleave", () => {

            item.style.background = "#ffffff";

        });

    });

    // ==========================
    // Current Date
    // ==========================

    const today = new Date();

    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    };

    const dateElement = document.querySelector(".current-date");

    if (dateElement) {

        dateElement.innerHTML =
            today.toLocaleDateString("en-US", options);

    }

    // ==========================
    // Live Clock
    // ==========================

    function updateClock() {

        const clock = document.querySelector(".clock");

        if (!clock) return;

        const now = new Date();

        clock.innerHTML =
            now.toLocaleTimeString();

    }

    setInterval(updateClock, 1000);

    updateClock();

    // ==========================
    // Sidebar Toggle
    // ==========================

    const toggle = document.querySelector(".menu-toggle");

    const sidebar = document.querySelector(".sidebar");

    if (toggle) {

        toggle.addEventListener("click", () => {

            sidebar.classList.toggle("show");

        });

    }

});
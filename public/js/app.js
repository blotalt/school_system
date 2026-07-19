

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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

const morningBtn = document.getElementById("morningBtn");
const afternoonBtn = document.getElementById("afternoonBtn");

morningBtn.onclick = function () {

    morningBtn.classList.add("active");
    afternoonBtn.classList.remove("active");

    document.getElementById("morningSchedule").style.display = "block";
    document.getElementById("afternoonSchedule").style.display = "none";

}

afternoonBtn.onclick = function () {

    afternoonBtn.classList.add("active");
    morningBtn.classList.remove("active");

    document.getElementById("morningSchedule").style.display = "none";
    document.getElementById("afternoonSchedule").style.display = "block";

}

document.addEventListener('DOMContentLoaded', () => {

    // Attendance Status Buttons
    const studentRows = document.querySelectorAll('.student-row');

    studentRows.forEach(row => {

        const buttons = row.querySelectorAll('.status-btn');
        const hiddenInput = row.querySelector('.attendance-input');

        buttons.forEach(button => {

            button.addEventListener('click', (e) => {

                e.preventDefault();

                // Remove active class from all buttons in this row
                buttons.forEach(btn => btn.classList.remove('active'));

                // Activate the clicked button
                button.classList.add('active');

                // Update hidden input value
                if (button.classList.contains('present')) {
                    hiddenInput.value = 'present';
                }

                if (button.classList.contains('late')) {
                    hiddenInput.value = 'late';
                }

                if (button.classList.contains('absent')) {
                    hiddenInput.value = 'absent';
                }

            });

        });

    });

    

});

document.addEventListener("DOMContentLoaded", function () {

    const rows = document.querySelectorAll(".attendance-status");

    rows.forEach(function (row) {

        const buttons = row.querySelectorAll(".status-btn");

        buttons.forEach(function (button) {

            button.addEventListener("click", function () {

                // Remove active from all buttons in this row
                buttons.forEach(function (btn) {
                    btn.classList.remove("active");
                });

                // Add active to the clicked button
                this.classList.add("active");

            });

        });

    });

});
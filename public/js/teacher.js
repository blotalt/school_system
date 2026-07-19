document.querySelectorAll(".teacher-attendance-status").forEach(row => {

    const buttons = row.querySelectorAll(".teacher-status-btn");

    buttons.forEach(button => {

        button.addEventListener("click", function(){

            buttons.forEach(btn => btn.classList.remove("active"));

            this.classList.add("active");

        });

    });

});
// Mark All Present
const markAllBtn = document.getElementById("markAllPresent");

if (markAllBtn) {

    markAllBtn.addEventListener("click", function () {

        document.querySelectorAll(".teacher-attendance-status").forEach(row => {

            const buttons = row.querySelectorAll(".teacher-status-btn");

            buttons.forEach(btn => btn.classList.remove("active"));

            const presentBtn = row.querySelector('[data-status="present"]');

            if (presentBtn) {
                presentBtn.classList.add("active");
            }

        });

    });

}
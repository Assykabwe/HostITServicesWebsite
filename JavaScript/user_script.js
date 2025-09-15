document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".sidebar ul li a");
    const sections = document.querySelectorAll(".content-section");
    const profileBox = document.querySelector('.profile-detail');

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Hide all sections
            sections.forEach(section => section.classList.remove("active"));

            // Remove active style from all links
            links.forEach(l => l.classList.remove("active"));

            // Show the clicked section
            const target = this.getAttribute("data-target");
            document.getElementById(target).classList.add("active");

            // Highlight active link
            this.classList.add("active");
        });
    });

    // Toggle user-icon
    const userIcon = document.querySelector('.user-icon i');
    userIcon?.addEventListener("click", () => {
        profileBox?.classList.toggle('active');
        searchForm?.classList.remove('active');
    });
});


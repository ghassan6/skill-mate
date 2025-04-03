document.addEventListener("DOMContentLoaded", function () {
    // Get the elements
    const summaryTab = document.getElementById("summary-tab");
    const editProfileTab = document.getElementById("edit-profile-tab");
    const summarySection = document.getElementById("summary-section");
    const editProfileSection = document.getElementById("edit-profile-section");

    // Show Summary and hide Edit Profile initially
    summaryTab.addEventListener("click", function () {
        summarySection.style.display = "block";
        editProfileSection.style.display = "none";

        summaryTab.classList.add("active");
        editProfileTab.classList.remove("active");
    });

    // Show Edit Profile and hide Summary
    editProfileTab.addEventListener("click", function () {
        summarySection.style.display = "none";
        editProfileSection.style.display = "block";

        summaryTab.classList.remove("active");
        editProfileTab.classList.add("active");
    });
});
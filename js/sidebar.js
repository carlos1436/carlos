$(document).ready(function() {
    // Sidebar overlay toggle functionality
    $(".menu-bar").click(function() {
        $(".sidebar-overlay").fadeToggle();
        $(".nav-sidebar").toggleClass("open");
    });

    // Close the sidebar overlay when clicking outside the sidebar
    $(".sidebar-overlay").click(function() {
        $(".sidebar-overlay").fadeOut();
        $(".nav-sidebar").removeClass("open");
    });
});

<!-- App js -
    ---------------
    ---------------
    ---------------
-->



<!-- Toggle Bar -->
<script>
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");


    sidebarToggle.addEventListener("click", () => {
        // Toggle the sidebar visibility
        sidebar.classList.toggle("active");

        // Check if the sidebar active
        if (sidebar.classList.contains("active")) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    
</script>

</body>

</html>

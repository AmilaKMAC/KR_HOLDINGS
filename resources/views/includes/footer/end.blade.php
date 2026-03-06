<!-- App js -
    ---------------
    ---------------
    ---------------
-->



<!-- ===================== Toggle Button ========================= -->

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


<!-- ======================== Limit Button Group ============================ -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

    // For tables directly on the page
    document.querySelectorAll('.card').forEach(card => {
        applyLimitButtons(card);
        initTable(card);
    });

    // For tables inside modals
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            applyLimitButtons(modal);
            initTable(modal);
        });
    });

    // Bind limit buttons inside a container
    function applyLimitButtons(container) {
        container.querySelectorAll('.limit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                container.querySelectorAll('.limit-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                applyLimit(container, this.dataset.limit);
            });
        });
    }

    // Apply row visibility and update showing info
    function applyLimit(container, limit) {
        const tbody = container.querySelector('tbody');
        if (!tbody) return;

        const allRows = Array.from(tbody.querySelectorAll('tr'));
        const lim = limit === 'all' ? 9999 : parseInt(limit);

        allRows.forEach((row, i) => {
            row.style.display = i < lim ? '' : 'none';
        });

        const shown = Math.min(lim, allRows.length);
        const infoEl = container.querySelector('.showing-info');
        if (infoEl) infoEl.innerText = `Showing 1 to ${shown} of ${allRows.length} entries`;
    }

    // Init: apply default limit of 5 on load/open
    function initTable(container) {
        const activeBtn = container.querySelector('.limit-btn[data-limit="5"]');
        if (activeBtn) {
            container.querySelectorAll('.limit-btn').forEach(b => b.classList.remove('active'));
            activeBtn.classList.add('active');
        }
        applyLimit(container, '5');
    }

});
</script>

</body>

</html>

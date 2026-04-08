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


<!-- ===================== Close Button ========================= -->
<script>
    // GLOBAL CLOSE BUTTON HANDLER
    document.addEventListener('DOMContentLoaded',

        function() {
            document.querySelectorAll('.btn-close').forEach(function(btn) {
                btn.addEventListener('click',
                    function() {
                        // Reload current page (BEST for all modules)
                        window.location.reload();

                        // dynamic redirect instead
                        let redirect = this.getAttribute('data-redirect');
                        if (redirect) {
                            window.location.href = redirect;
                        }
                    });
            });
        });

    //  OPEN NESTED MODAL
    function openNestedModal(parentId, childId) {
        const parentEl = document.getElementById(parentId);
        bootstrap.Modal.getInstance(parentEl)?.hide();

        parentEl.addEventListener('hidden.bs.modal',
            function handler() {
                new bootstrap.Modal(document.getElementById(childId)).show();
                parentEl.removeEventListener('hidden.bs.modal', handler);
            });
    }

    //  CLOSE CHILD & RETURN TO PARENT
    function closeAndReturn(childId, parentId) {
        const childEl = document.getElementById(childId);
        bootstrap.Modal.getInstance(childEl)?.hide();

        childEl.addEventListener('hidden.bs.modal',
            function handler() {
                new bootstrap.Modal(document.getElementById(parentId)).show();
                childEl.removeEventListener('hidden.bs.modal', handler);
            });
    }
</script>


<!-- DataTables -->
<script>
    $(document).ready(function () {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>

@stack('scripts')

</body>

</html>

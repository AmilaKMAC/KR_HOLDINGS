<script>
    function printModal(modalId, title) {
        const wrapper = document.querySelector(`#${modalId} .table-responsive`);
        const table = wrapper ? wrapper.querySelector('table') : document.querySelector(`#${modalId} table`);
        openPrintWindow(title, table.outerHTML);
    }

function printDetailModal(modalId, title) {
    const body = document.querySelector(`#${modalId} .modal-body`);
    if (!body) return;

    let html = '';

    // Walk through all children in DOM order
    body.childNodes.forEach(node => {
        if (node.nodeType !== Node.ELEMENT_NODE) return;

        // If it's a heading, add it directly
        if (['H4', 'H5', 'H6'].includes(node.tagName)) {
            html += node.outerHTML;
        }
        // If it's a table with tbody, add it directly
        else if (node.tagName === 'TABLE' && node.querySelector('tbody')) {
            html += node.outerHTML;
        }
        // If it's a wrapper (div, table-responsive, dataTables_wrapper etc), look inside
        else {
            node.querySelectorAll('h4, h5, h6').forEach(h => {
                html += h.outerHTML;
            });
            node.querySelectorAll('table').forEach(table => {
                if (table.querySelector('tbody')) {
                    html += table.outerHTML;
                }
            });
        }
    });

    openPrintWindow(title, html);
}

    function openPrintWindow(title, content) {
        const win = window.open('', '_blank');
        win.document.write(`<!DOCTYPE html><html>
        <head>
            <title>${title}</title>
            <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
            <style>
                body { padding: 24px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
                th, td { border: 1px solid #dee2e6; padding: 8px; text-align: center; }
                thead { background-color: #f8f9fa; }
                h6 { margin-top: 16px; }
                @media print { @page { margin: 15mm; } }
            </style>
        </head>
        <body>
            <h5>${title}</h5>
            ${content}
            <script>window.onload = function(){ window.print(); window.close(); }<\/script>
        </body>
        </html>`);
        win.document.close();
    }
</script>
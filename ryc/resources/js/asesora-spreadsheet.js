document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('spreadsheet');

    let allData = [];
    let currentFilter = 'all';

    function getStatusColor(status) {
        const colors = {
            'ingreso': '#3b82f6',
            'contacto': '#f59e0b',
            'venta cerrada': '#10b981',
            'no interesado': '#ef4444'
        };
        return colors[status] || '#3b82f6';
    }

    function fetchLeads() {
        fetch('/api/leads')
            .then(res => res.json())
            .then(data => {
                allData = data;
                renderSpreadsheet();
            })
            .catch(err => console.error('Error fetching leads:', err));
    }

    function renderSpreadsheet() {
        const filteredData = currentFilter === 'all'
            ? allData
            : allData.filter(lead => lead.status === currentFilter);

        const data = filteredData.map(lead => [
            lead.nombre,
            lead.celular,
            lead.correo || '',
            lead.curso,
            lead.consulta || '',
            lead.status,
            new Date(lead.created_at).toLocaleDateString('es-PE')
        ]);

        if (window.hotInstance) {
            window.hotInstance.destroy();
        }

        window.hotInstance = new Handsontable(container, {
            data: data,
            colHeaders: ['Nombre', 'Celular', 'Correo', 'Curso', 'Consulta', 'Estado', 'Fecha'],
            columns: [
                { data: 0, readOnly: true },
                {
                    data: 1,
                    readOnly: true,
                    renderer: function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        if (filteredData[row] && filteredData[row].is_whatsapp) {
                            td.style.backgroundColor = '#16a34a';
                            td.style.color = 'white';
                            td.style.fontWeight = 'bold';
                        }
                    }
                },
                { data: 2, readOnly: true },
                { data: 3, readOnly: true },
                { data: 4, readOnly: true },
                {
                    data: 5,
                    editor: 'select',
                    selectOptions: ['ingreso', 'contacto', 'venta cerrada', 'no interesado'],
                    renderer: function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.backgroundColor = getStatusColor(value);
                        td.style.color = 'white';
                        td.style.fontWeight = 'bold';
                        td.style.textAlign = 'center';
                    }
                },
                { data: 6, readOnly: true }
            ],
            rowHeaders: true,
            manualColumnResize: true,
            filters: true,
            dropdownMenu: true,
            height: 600,
            afterChange: function(changes, source) {
                if (source === 'loadData' || !changes) return;

                changes.forEach(([row, prop, oldValue, newValue]) => {
                    if (prop === 5 && oldValue !== newValue) {
                        const lead = filteredData[row];
                        if (lead && lead.id) {
                            updateLeadStatus(lead.id, newValue);
                        }
                    }
                });
            },
            cells: function(row, col) {
                const cellProperties = {};
                if (filteredData[row] && filteredData[row].is_whatsapp && col !== 1) {
                    cellProperties.renderer = function(instance, td, row, col, prop, value) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.backgroundColor = '#e5f3e5';
                    };
                }
                return cellProperties;
            }
        });
    }

    function updateLeadStatus(leadId, newStatus) {
        fetch(`/api/leads/${leadId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            const index = allData.findIndex(l => l.id === leadId);
            if (index !== -1) {
                allData[index] = data;
            }
        })
        .catch(err => console.error('Error updating lead:', err));
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            renderSpreadsheet();
        });
    });

    fetchLeads();

    // Real-time updates via polling (fallback) + optional WebSocket
    let pollInterval = setInterval(fetchLeads, 5000); // Poll every 5 seconds

    // Try Laravel Echo for real-time updates (optional)
    if (typeof Echo !== 'undefined') {
        const advisorId = window.ADVISOR_ID || 1;

        Echo.join(`leads.${advisorId}`)
            .here(users => console.log('Users online:', users))
            .joining(user => console.log('User joined:', user))
            .leaving(user => console.log('User left:', user))
            .listen('lead.updated', (e) => {
                console.log('Lead updated via WebSocket:', e.lead);
                clearInterval(pollInterval); // Stop polling when WebSocket works
                const index = allData.findIndex(l => l.id === e.lead.id);
                if (index !== -1) {
                    allData[index] = e.lead;
                } else {
                    allData.unshift(e.lead);
                }
                renderSpreadsheet();
            });
    } else {
        console.log('Laravel Echo not loaded. Using polling for real-time updates.');
    }
});

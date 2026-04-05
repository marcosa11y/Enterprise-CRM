document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.kanban-card');
    const columns = document.querySelectorAll('.kanban-cards');

    cards.forEach(card => {
        card.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', this.dataset.dealId);
            this.classList.add('dragging');
        });

        card.addEventListener('dragend', function() {
            this.classList.remove('dragging');
        });
    });

    columns.forEach(column => {
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        column.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        column.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            const dealId = e.dataTransfer.getData('text/plain');
            const stageId = this.dataset.stageId;
            
            // Update stage via AJAX
            fetch(site_url + 'deals/update_stage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'deal_id=' + dealId + '&stage_id=' + stageId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = document.querySelector('[data-deal-id="' + dealId + '"]');
                    this.appendChild(card);
                } else {
                    alert('Failed to update deal stage');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update deal stage');
            });
        });
    });
});
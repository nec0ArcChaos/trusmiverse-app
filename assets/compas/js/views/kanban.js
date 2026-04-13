
window.LoadInit = window.LoadInit || {};
window.LoadInit['views'] = window.LoadInit['views'] || {};
window.LoadInit['views']['kanban'] = function (container) {
    // We need to wait a tick for the DOM to be fully ready if elements are dynamically injected
    setTimeout(() => {
        if (typeof dragula !== 'undefined') {
            var containers = [
                container.querySelector('#waitingcolumn'),
                container.querySelector('#onreviewcolumn'),
                container.querySelector('#approvedcolumn')
            ].filter(el => el !== null); // Ensure elements exist

            if (containers.length > 0) {
                 var drake = dragula(containers, {
                    moves: function (el, container, handle) {
                        return handle.classList.contains('cursor-grab') || handle.closest('.cursor-grab');
                    }
                });

                drake.on('drag', function (el) {
                    el.classList.add('shadow-lg');
                });

                drake.on('dragend', function (el) {
                    el.classList.remove('shadow-lg');
                });

                drake.on('drop', function (el, target, source, sibling) {
                    if (el.hasAttribute('onclick')) {
                        const match = el.getAttribute('onclick').match(/loadDetails\(['"]([^'"]+)['"]\)/);
                        if (match && match[1]) {
                            loadDetails(match[1]);
                        }
                    }
                });
            }
        }
    }, 100);
    initDateRange('kanban');

    // Add sorting logic
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const sortType = this.textContent.trim();
            const column = this.closest('.col-12').querySelector('.dragzonecard');
            
            if (!column) return;

            const cards = Array.from(column.querySelectorAll('.card'));
            
            if (sortType === 'Sort by Date') {
                cards.sort((a, b) => {
                    const dateA = parseInt(a.getAttribute('data-date')) || 0;
                    const dateB = parseInt(b.getAttribute('data-date')) || 0;
                    return dateB - dateA; // Descending (newest first)
                });
            } else if (sortType === 'Sort by Status') {
                cards.sort((a, b) => {
                    const prioA = parseInt(a.getAttribute('data-priority')) || 3;
                    const prioB = parseInt(b.getAttribute('data-priority')) || 3;
                    return prioA - prioB; // Ascending (1=Late, 2=At Risk, 3=On Track)
                });
            }

            // Re-append sorted cards
            cards.forEach(card => column.appendChild(card));
        });
    });
};



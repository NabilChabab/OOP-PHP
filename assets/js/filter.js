        const searchTermInput = document.getElementById('searchTerm');
        const userTableBody = document.getElementById('userTableBody');

        searchTermInput.addEventListener('input', debounce(function () {
            const searchTerm = searchTermInput.value.trim().toLowerCase();
            const rows = userTableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (const cell of cells) {
                    const text = cell.innerText.toLowerCase();

                    if (text.includes(searchTerm)) {
                        found = true;
                        break;
                    }
                    
                }

                row.style.display = found ? '' : 'none';
            }
        }, 0));

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('active');
            });
        });

        // Search functionality
        document.querySelector('.search-btn').addEventListener('click', () => {
            const searchTerm = document.querySelector('.search-box').value;
            if (searchTerm.trim() !== '') {
                alert(`Searching for: ${searchTerm}`);
                // In a real application, this would trigger an API call or filter results
            }
        });

        // Allow pressing Enter to search
        document.querySelector('.search-box').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.querySelector('.search-btn').click();
            }   
        });


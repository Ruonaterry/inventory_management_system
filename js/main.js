// Alert functions
function showAlert(message, type = 'success') {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.textContent = message;
        alert.className = `alert ${type} active`;
        
        setTimeout(() => {
            alert.classList.remove('active');
        }, 5000);
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('searchBox');
    if (searchBox) {
        searchBox.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const table = this.closest('.table-container').querySelector('table tbody');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
});

// Form reset function
function resetForm() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.reset();
        const hiddenIds = form.querySelectorAll('input[type="hidden"]');
        hiddenIds.forEach(input => input.value = '');
    });
    
    // Reset button text back to "Add"
    const submitBtn = document.querySelector('button[name="action"]');
    if (submitBtn) {
        if (submitBtn.closest('form').id === 'productForm') {
            submitBtn.textContent = 'Add Product';
            submitBtn.value = 'add';
        } else if (submitBtn.closest('form').id === 'categoryForm') {
            submitBtn.textContent = 'Add Category';
            submitBtn.value = 'add';
        } else if (submitBtn.closest('form').id === 'supplierForm') {
            submitBtn.textContent = 'Add Supplier';
            submitBtn.value = 'add';
        }
    }
}

// Confirmation dialog
function confirmAction(message) {
    return confirm(message);
}

// View product details
function viewProduct(product) {
    const modal = document.getElementById('productModal');
    const detailsDiv = document.getElementById('productDetails');
    
    // Determine stock status
    let status = '';
    let statusClass = '';
    if (product.quantity == 0) {
        status = 'Out of Stock';
        statusClass = 'out-of-stock';
    } else if (product.quantity <= product.reorder_level) {
        status = 'Low Stock';
        statusClass = 'low-stock';
    } else {
        status = 'In Stock';
        statusClass = 'in-stock';
    }
    
    detailsDiv.innerHTML = `
        <p><strong>Product ID:</strong> ${product.product_id}</p>
        <p><strong>Product Name:</strong> ${product.product_name}</p>
        <p><strong>SKU:</strong> ${product.sku}</p>
        <p><strong>Category:</strong> ${product.category_name || 'N/A'}</p>
        <p><strong>Supplier:</strong> ${product.supplier_name || 'N/A'}</p>
        <p><strong>Description:</strong> ${product.description || 'No description'}</p>
        <p><strong>Quantity:</strong> ${product.quantity} ${product.unit || ''}</p>
        <p><strong>Price:</strong> $${parseFloat(product.price).toFixed(2)}</p>
        <p><strong>Reorder Level:</strong> ${product.reorder_level}</p>
        <p><strong>Status:</strong> <span class="status ${statusClass}">${status}</span></p>
        <p><strong>Created:</strong> ${new Date(product.created_at).toLocaleDateString()}</p>
    `;
    
    modal.classList.add('active');
}

// Close product modal
function closeProductModal() {
    document.getElementById('productModal').classList.remove('active');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        closeProductModal();
    }
}

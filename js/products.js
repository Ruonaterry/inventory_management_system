// Edit Product
function editProduct(product) {
    document.getElementById('product_id').value = product.product_id;
    document.getElementById('product_name').value = product.product_name;
    document.getElementById('sku').value = product.sku;
    document.getElementById('category_id').value = product.category_id;
    document.getElementById('supplier_id').value = product.supplier_id;
    document.getElementById('quantity').value = product.quantity;
    document.getElementById('price').value = product.price;
    document.getElementById('reorder_level').value = product.reorder_level;
    document.getElementById('unit').value = product.unit;
    document.getElementById('description').value = product.description;
    
    // Change button text
    const submitBtn = document.querySelector('button[name="action"]');
    submitBtn.textContent = 'Update Product';
    submitBtn.value = 'update';
    
    // Scroll to form
    document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
}

// Delete Product
function deleteProduct(productId) {
    if (confirmAction('Are you sure you want to delete this product?')) {
        window.location.href = `../includes/process_product.php?action=delete&id=${productId}`;
    }
}

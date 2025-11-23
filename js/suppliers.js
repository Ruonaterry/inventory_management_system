// Edit Supplier
function editSupplier(supplier) {
    document.getElementById('supplier_id').value = supplier.supplier_id;
    document.getElementById('supplier_name').value = supplier.supplier_name;
    document.getElementById('contact_person').value = supplier.contact_person;
    document.getElementById('email').value = supplier.email;
    document.getElementById('phone').value = supplier.phone;
    document.getElementById('address').value = supplier.address;
    
    // Change button text
    const submitBtn = document.querySelector('button[name="action"]');
    submitBtn.textContent = 'Update Supplier';
    submitBtn.value = 'update';
    
    // Scroll to form
    document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
}

// Delete Supplier
function deleteSupplier(supplierId) {
    if (confirmAction('Are you sure you want to delete this supplier?')) {
        window.location.href = `../includes/process_supplier.php?action=delete&id=${supplierId}`;
    }
}

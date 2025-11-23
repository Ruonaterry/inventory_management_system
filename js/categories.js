// Edit Category
function editCategory(category) {
    document.getElementById('category_id').value = category.category_id;
    document.getElementById('category_name').value = category.category_name;
    document.getElementById('category_code').value = category.category_code;
    document.getElementById('description').value = category.description;
    
    // Change button text
    const submitBtn = document.querySelector('button[name="action"]');
    submitBtn.textContent = 'Update Category';
    submitBtn.value = 'update';
    
    // Scroll to form
    document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth' });
}

// Delete Category
function deleteCategory(categoryId) {
    if (confirmAction('Are you sure you want to delete this category?')) {
        window.location.href = `../includes/process_category.php?action=delete&id=${categoryId}`;
    }
}

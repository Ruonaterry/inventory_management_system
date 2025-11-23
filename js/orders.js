// Open Order Modal
function openOrderModal() {
    document.getElementById('orderModal').classList.add('active');
}

// Close Order Modal
function closeOrderModal() {
    document.getElementById('orderModal').classList.remove('active');
    document.getElementById('orderForm').reset();
}

// View Order Details
function viewOrderDetails(orderId) {
    window.location.href = `order_details.php?id=${orderId}`;
}

// Update Order Status
function updateOrderStatus(orderId) {
    const newStatus = prompt('Enter new status (Pending/Processing/Completed/Cancelled):');
    if (newStatus) {
        window.location.href = `../includes/process_order.php?action=update_status&id=${orderId}&status=${newStatus}`;
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target == modal) {
        closeOrderModal();
    }
}

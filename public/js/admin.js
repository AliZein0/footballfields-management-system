// Admin Dashboard JavaScript

// Toggle sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const contentWrapper = document.querySelector('.content-wrapper');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            contentWrapper.classList.toggle('full-width');
        });
    }
    
    // Auto-close sidebar on small screens when clicking outside
    document.addEventListener('click', function(event) {
        const windowWidth = window.innerWidth;
        if (windowWidth < 576 && 
            !sidebar.contains(event.target) && 
            !sidebarToggle.contains(event.target) &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize alerts to auto-close
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Form submission confirmation
    const confirmForms = document.querySelectorAll('.confirm-submit');
    confirmForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!confirm('Are you sure you want to perform this action?')) {
                event.preventDefault();
                return false;
            }
        });
    });
});

// Date formatting helper function
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}


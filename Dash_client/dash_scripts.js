document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.main-btn').forEach(button => {
        button.addEventListener('click', function() {
            const section = this.getAttribute('data-section');
            showPopover(section);
        });
    });
    function handleSelections(containerClass) {
        const container = document.querySelector(containerClass);
        if (!container) return;
        const items = container.children;
        Array.from(items).forEach(item => {
            item.addEventListener('click', function() {
                Array.from(items).forEach(otherItem => {
                    otherItem.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
    }
    handleSelections('.service-selection');
    handleSelections('.therapist-selection');
    handleSelections('.schedule-selection');
});

function showPopover(section) {
    const popovers = document.querySelectorAll('.popover');
    const targetPopover = document.getElementById(`${section}-popover`);
    popovers.forEach(popover => {
        popover.style.display = 'none';
    });
    if (targetPopover) {
        targetPopover.style.display = 'block';
    }
}

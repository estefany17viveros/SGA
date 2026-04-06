<script>
function toggleMenu(menuId) {
    document.querySelectorAll('[id^="menu"]').forEach(menu => {
        if (menu.id !== menuId) {
            menu.classList.add('hidden');
        }
    });

    document.getElementById(menuId).classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('[id^="menu"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>
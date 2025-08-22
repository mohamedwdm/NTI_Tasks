<?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success mt-3 flash-message">
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']); } ?>

<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger mt-3 flash-message">
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']); } ?>

<script>
    document.querySelectorAll('.flash-message').forEach(msg => {
        setTimeout(() => {
            // msg.style.transition = "opacity 0.8s ease";
            // msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 500);
        }, 3000);
    });
</script>

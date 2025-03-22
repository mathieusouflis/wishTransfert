<?php
require_once "./0 FRONT/composents/icons.php";

function errorModal(array $errors = []) {
    $phpErrors = error_get_last();
    if ($phpErrors) {
        // Add PHP error to the errors array
        if (!is_array($errors)) {
            $errors = [];
        }
        $errors[] = $phpErrors['message'];
    }
    if (!empty($errors)) {
        ?>
        <div class="fixed top-20 left-20 z-50 flex flex-col gap-10">
            <?php foreach ($errors as $error): ?>
                <div class="error-notification relative flex items-center justify-between bg-primary text-white px-10 py-8 border-radius20" role="alert">
                    <span class="text-12"><?= htmlspecialchars($error) ?></span>
                    <button onclick="this.parentElement.remove()" class="ml-20 text-white">
                        <?php icon("x", "small", "white")?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            document.querySelectorAll('.error-notification').forEach(notification => {
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 60000);
            });
        </script>
        <?php
    }
}
?>
<?php if(!empty($erreurs)): ?>
    <div>
        <ul>
            <?php foreach ($erreurs as $erreur): ?>
            <li><?= $erreur ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
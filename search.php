 <?php if ($error): ?>
        <div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <h3>Rezultati za: <em><?php echo htmlspecialchars($query); ?></em></h3>
        <ul class="list-group">
            <?php foreach ($results as $row): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($row['ime_recepta']); ?></strong><br>
                    <?php echo nl2br(htmlspecialchars($row['opis'] ?? '')); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>

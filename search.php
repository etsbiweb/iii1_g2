<?php include 'search_process.php'; ?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Rezultati pretrage - Kuharica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Pretraga recepata</h1>

    <form method="GET" action="search.php" class="d-flex mb-4">
        <input class="form-control" type="text" name="query" placeholder="Unesi naziv recepta..." required
               value="<?php echo htmlspecialchars($query); ?>">
        <button class="btn btn-dark ms-2" type="submit">Search</button>
    </form>

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

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php'; ?>
    <title>Todo</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>
        <div class="content">
            <div class="todo-container">
                <h1>Ma Todo</h1>
                <?php require_once 'includes/index.php'; ?>
                <form action="" method="">
                    <input type="text" name="todo" id="name">
                    <div class="todo-form"></div>
                    <div class="todo-list"></div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>
    </div>
</body>

</html>
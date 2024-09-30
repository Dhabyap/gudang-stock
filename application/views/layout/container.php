<!DOCTYPE html>
<html lang="en">

<head>
    <?= $head ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?= $sidebar ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?= $navbar ?>
                <?= $content ?>
            </div>
            <?= $footer; ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?= $script ?>
</body>

</html>
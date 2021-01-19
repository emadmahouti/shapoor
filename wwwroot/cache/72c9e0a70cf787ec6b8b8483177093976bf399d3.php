<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Soda - Yet another PHP framework</title>

    <script src="vendor/vue/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <style>
        textarea:hover,
        input:hover,
        textarea:active,
        input:active,
        textarea:focus,
        input:focus,
        button:focus,
        button:active,
        button:hover,
        label:focus,
        .btn:active,
        .btn.active
        {
            outline:0px !important;
            -webkit-appearance:none;
            box-shadow: none !important;
        }
    </style>

    <?php echo $__env->yieldContent('header'); ?>

</head>

<body>

    <div id="app" v-cloak>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.js"></script>
    <script src='https://cdn.rawgit.com/lcdsantos/menuspy/fa5bc803/dist/menuspy.min.js'></script>

    <?php echo $__env->yieldContent('script'); ?>

</body>

</html>
<?php /**PATH C:\htdocs\operation\app\views/layouts/master.blade.php ENDPATH**/ ?>
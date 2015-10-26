<?php

    $path = getcwd();

    function getDirectorySize($path) {
        $objects = new DirectoryIterator($path);
        $size = 0;
        foreach ( $objects as $object ) {
            if ( $object->isFile() ) {
                $size += $object->getSize();
            }
        }

        return $size;
    }

    $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
    );

    $dirlist = [];
    foreach ( $objects as $name => $object ) {
        if ( $object->isDir() ) {
            $dirlist[$object->getPathName()] = getDirectorySize($object->getPathName());
        }
    }

    arsort($dirlist);

?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
</head>
<body>


<h1><?php echo htmlentities($path) ?></h1>
<table class="table table-condensed table-hover">
    <thead>
    <tr>
        <th>Path</th>
        <th class="text-right">Size</th>
    </tr>
    </thead>
    <?php
        foreach ( $dirlist as $dir => $size ) { ?>
            <tr>
                <td><?php echo htmlentities($dir) ?></td>
                <td class="text-right"><?php echo number_format($size / 1024) ?> KB</td>
            </tr>
        <?php } ?>
</table>
</body>
</html>

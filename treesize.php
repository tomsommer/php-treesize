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
<html>
<head>
    <meta charset="utf-8">
	<meta name="robots" content="noindex">
    <title>Treesize: <?php echo htmlentities($path) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
	<h1 class="display-4"><?php echo htmlentities($path) ?></h1>
    <table class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th>Path</th>
            <th class="text-right">Size</th>
        </tr>
        </thead>
        <?php foreach ( $dirlist as $dir => $size ) { ?>
          <tr>
            <th class="text-monospace"><?php echo htmlentities($dir) ?></th>
            <td class="text-right small text-nowrap"><?php echo number_format($size / 1024, 0, ',', '.') ?> KB</td>
          </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

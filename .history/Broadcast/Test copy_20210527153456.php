<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>RequireJS Tutorial</title>
    <script src="<?php echo $SCRIPT_ADDRESS;?>require.js"></script>
    <script>
    var a = require('crypto');
    </script>

  </head>
  <body>
    <h1 id="header">My Sample Project</h1>
    <h3 id="header"><?php echo $SCRIPT_ADDRESS;?></h3>

  </body>
</html>
<?php
session_start();
session_unset();
session_destroy();

setcookie('id','', time() - 3600);
setcookie('key','', time() - 3600);

echo " <script>
        alert('berhasil logout');
        document.location='login.php';
        </script> ";
?>
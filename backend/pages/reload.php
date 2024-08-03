<?php
include "./header.php";
include $_SERVER["DOCUMENT_ROOT"] . "/futbol-libre-status/process/p-reload.php";
?>
<form action="" method="post">
    <div>
        <label for="keywords">Palabras claves</label>
        <input type="text" minlength="6" maxlength="100" name="keywords" id="keywords" placeholder="Futbol libre" required/>
    </div>
    <div>
        <input type="submit" name="submitReload" value="Recargar" />
    </div>
</form>
</body>
</html>

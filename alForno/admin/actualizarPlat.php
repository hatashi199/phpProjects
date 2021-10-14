<?php
    require "includes/common.php";
    $iplat = $_POST['iplat'];
    $plat = $_POST['plato'];
    $descrip = $_POST['descripPlato'];
    $precio = $_POST['precio'];
    $valoracion = $_POST['valoracion'];
    $img = "";
    $cat = $_POST['selectCat'];

    if((isset($_FILES['imgPlato'])) && ($_FILES['imgPlato']['error'] === UPLOAD_ERR_OK)) {
        $dirTemp = $_FILES['imgPlato']['tmp_name'];
        $nombFich = $_FILES['imgPlato']['name'];
        $tamFich = $_FILES['imgPlato']['size'];
        $tipoFich = $_FILES['imgPlato']['type'];

        $nombFich_Comp = explode('.',$nombFich);
        $extFich = strtolower(end($nombFich_Comp));

        $nuevoNombFich = time()."_".$nombFich;

        $extPermit = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc','pdf','svg','jpeg','webp');

        if (in_array($extFich,$extPermit)) {
            $dirSubida = "../images/carta";
            $dirDest = $dirSubida.$nuevoNombFich;
            
            if (move_uploaded_file($dirTemp,$dirDest)) {
                $img = $nuevoNombFich;
            }
        } else {
            echo "Subida errónea. Tipos soportados: ".implode(",",$extPermit);
        }
    }

    if ($img=="") {
        $sql1="update platos set nombre='$plat',descripcion='$descrip',precio='$precio',valoracion='$valoracion',id_categoria='$cat'
                where id_plato='$iplat'";
    } else {
        $sql1="update platos set nombre='$plat',descripcion='$descrip',precio='$precio',valoracion='$valoracion',foto='$img',id_categoria='$cat'
        where id_plato='$iplat'";
    }

    $db->query($sql1);

    header("Location: ./index.php");
?>
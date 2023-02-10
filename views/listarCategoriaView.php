<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 6</title>
    <link rel="stylesheet" type="text/css" href="views/css/estilos.css" />  

</head>
<body>

<table>
        <tr>
            <th>ID
            </th>
            <th>NOMBRE
            </th>            
        </tr>
        <?php
        foreach ($categorias as $categoria) {
        ?>
        <tr>
            <td><?php echo $categoria->getCat_id() ?></td>
            <td><?php echo $categoria->getCat_nombre() ?></td>                     
            <script defer>
                //con este script pedimos confirmación antes de borrar un registro
                function confirmacion(cat)
                {
                    
                                        
                    let respuesta= confirm("Desea borrar la Categoria "+cat+" ?")
                    if(respuesta)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            </script>

            <td><a href="index.php?controlador=categoria&accion=editar&cat_id=<?php echo $categoria->getCat_id() ?>">Editar</a>
            </td>            
            <td><a href="index.php?controlador=categoria&accion=borrar&cat_id=<?php echo $categoria->getCat_id() ?>" onclick="return  confirmacion('<?php echo $categoria->getCat_nombre()?>')" >Borrar</a>
            </td>
            
        </tr>
        <?php
        }
        ?>
    </table>
    <?php include_once("common/pie.php"); ?>

    
</body>
</html>
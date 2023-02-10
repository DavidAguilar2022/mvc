<?php
//importamos La clase de CategoriaModel
require "models/CategoriaModel.php";
//creamos una instancia de CategoriaModel
$cat=new CategoriaModel();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            <th>CATEGORIA
            </th>
            <th>CANTIDAD
            </th>
        </tr>
        <?php
        foreach ($articulos as $articulo) {
        ?>
        <tr>
            <td><?php echo $articulo->getArt_id() ?></td>
            <td><?php echo $articulo->getArt_nombre() ?></td>
            <td>
                <?php
                    //listamos el nombre de la categoría
                    //usamos la consulta preparada de CategoriaModel
                    $res=$cat->getById($articulo->getArt_categoria());
                    echo $res->getCat_nombre();

                
                ?>
            </td>
            <td><?php echo $articulo->getArt_cantidad() ?></td>           

            <td><a href="index.php?controlador=articulo&accion=editar&art_id=<?php echo $articulo->getArt_id() ?>">Editar</a>
            </td>            
            <td><a href="index.php?controlador=articulo&accion=borrar&art_id=<?php echo $articulo->getArt_id() ?>" onclick="return  confirmacion('<?php echo $articulo->getArt_nombre() ?>','<?php echo $articulo->getArt_categoria()?>','<?php echo $articulo->getArt_cantidad()?>')">Borrar</a>            
            </td>
            <script>
                //con este script pedimos confirmación antes de borrar un registro
                function confirmacion(nombre,categoria,cantidad)
                {
                                       
                    let respuesta= confirm("Desea borrar el Articulo "+nombre+" de la categoría: "+categoria+" y cantidad: "+cantidad+" ?")
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
            
        </tr>
        
        <?php
        
        }
        ?>
         
        
            
    </table>
    <?php include_once("common/pie.php"); ?>

</body>
</html>
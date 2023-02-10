<?php


    //creamos nuestra clase controlador corresponidente al modelo, en este caso categoría
    class CategoriaController{


        protected $view;

        public function __construct()
        {
             //Creamos una instancia de nuestro mini motor de plantillas
            $this->view=new  View();
        }

        //metodo del controlador para listar las categorias almacenadas
        public function listar()
        {
            //incluimos el modelo de articulo
            require "models/CategoriaModel.php";

            //se crea una instancia de nuestro modelo
            $categorias=new CategoriaModel();

            //le pedimos al modelo todos los articulos
            $listado=$categorias->getAll();

            //pasammos a la vista todos los articulos
            $data['categorias']=$listado;

            // Finalmente presentamos nuestra plantilla 
            // Llamamos al método "show" de la clase View, que es el motor de plantillas
            // Genera la vista de respuesta a partir de la plantilla y de los datos
            $this->view->show("listarCategoriaView.php", $data);



        }

        //este el punto de entrada por defecto para frontController
        public function index()
        {
            //Incluye el modelo que corresponde
            require_once 'models/CategoriaModel.php';

            //Creamos una instancia de nuestro "modelo"
            $categorias = new CategoriaModel();

            //Le pedimos al modelo todas las cetgorias
            $listado = $categorias->getAll();

            //Pasamos a la vista toda la información que se desea representar
            $data['categoria'] = $listado;

            //Finalmente presentamos nuestra plantilla
            $this->view->show("listarCategoriaView.php", $data);
        }



        public function nuevo()
        {

            //incluimos el modelo de categoria
            require "models/CategoriaModel.php";

            //se crea una instancia de nuestro modelo
            $categoria=new CategoriaModel();

            $errores=array();

             // Si recibe por GET o POST el objeto y lo guarda en la BD
            if (isset($_REQUEST['submit'])) {
                if (!isset($_REQUEST['cat_nombre']) || empty($_REQUEST['cat_nombre']))
                    $errores['categoria'] = "* Categoria: Error";
                if (empty($errores)) {
                    //añadimos el campo de categoria para luego poder guardar mediante el metodo save a la base datos
                    $categoria->setCat_nombre($_REQUEST['cat_nombre']);
                    $categoria->save();

                    // Finalmente llama al método listar para que devuelva vista con listado
                    header("Location: index.php?controlador=categoria&accion=listar");
                }
            }

            // Si no recibe el item para añadir, devuelve la vista para añadir un nuevo articulo
            $this->view->show("nuevaCategoriaView.php", array('errores' => $errores));



        }


         // Método que procesa la petición para editar una categoria
         public function editar()
         {
 
             require 'models/CategoriaModel.php';
             $categorias = new CategoriaModel();
 
             // Recuperar el item con el código recibido
             $categoria = $categorias->getById($_REQUEST['cat_id']);
             if ($categoria == null) {
                 $this->view->show("errorView.php", array('error' => 'No existe codigo'));
             }
 
             $errores = array();
 
             // Si se ha pulsado el botón de actualizar
             if (isset($_REQUEST['submit'])) {
 
                 if (!isset($_REQUEST['cat_nombre']) || empty($_REQUEST['cat_nombre']))
                     $errores['categoria'] = "* Categoria: Error";
 
                 if (empty($errores)) {
                     //añadimosel campo de categoria para luego poder guardar mediante el metodo save a la base datos, al tener un id, hará un update
                     $categoria->setCat_nombre($_REQUEST['cat_nombre']);
                     $categoria->save();
 
                     // Reenvía a la aplicación a la lista de items
                     header("Location: index.php?controlador=categoria&accion=listar");
                 }
             }
 
             // Si no se ha pulsado el botón de actualizar se carga la vista para editar el item
             $this->view->show("editarCategoriaView.php", array('categoria' => $categoria, 'errores' => $errores));
 
 
 
         }

            // Método para borrar una categoria 
            public function borrar()
            {
                //Incluye el modelo que corresponde
                require_once 'models/CategoriaModel.php';

                //Creamos una instancia de nuestro "modelo"
                $categorias = new CategoriaModel();

                // Recupera el item con el código recibido por GET o por POST
                $categoria = $categorias->getById($_REQUEST['cat_id']);

                if ($categoria == null) {
                    $this->view->show("errorView.php", array('error' => 'No existe codigo'));
                } else {
                    // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación
                    $categoria->delete();
                    header("Location: index.php");
                }
            }

            











    }











?>
<?php

    //habrá una clase controlador por cada clase modelo 
    class ArticuloController{

        protected $view;

        //en el constructo creamos un objeto viev y lo asignamos a nuestro campo view
        public function __construct()
        {
            //Creamos una instancia de nuestro mini motor de plantillas
            $this->view=new View();
        
        }

        //metodo del controlador para listar articulos almacenados
        public function listar()
        {
            //incluimos el modelo de articulo
            require "models/ArticuloModel.php";

            //se crea una instancia de nuestro modelo
            $articulos=new ArticuloModel();

            //le pedimos al modelo todos los articulos
            $listado=$articulos->getAll();

            //pasammos a la vista todos los articulos
            $data['articulos']=$listado;

            // Finalmente presentamos nuestra plantilla 
            // Llamamos al método "show" de la clase View, que es el motor de plantillas
            // Genera la vista de respuesta a partir de la plantilla y de los datos
            $this->view->show("listarView.php", $data);



        }

        
        //este el punto de entrada por defecto para frontController
         public function index()
        {
            //Incluye el modelo que corresponde
            require_once 'models/ArticuloModel.php';

            //Creamos una instancia de nuestro "modelo"
            $articulos = new ArticuloModel();

            //Le pedimos al modelo todos los items
            $listado = $articulos->getAll();

            //Pasamos a la vista toda la información que se desea representar
            $data['articulos'] = $listado;

            //Finalmente presentamos nuestra plantilla
            $this->view->show("listarView.php", $data);
        }

        
        
        

        public function nuevo()
        {

            //incluimos el modelo de articulo
            require "models/ArticuloModel.php";

            //se crea una instancia de nuestro modelo
            $articulo=new ArticuloModel();

            $errores=array();

             // Si recibe por GET o POST el objeto y lo guarda en la BD
            if (isset($_REQUEST['submit'])) {
                //controlamos que no quede nada vacio en el formulario y que la cantidad no sea negativa
                if (!isset($_REQUEST['art_nombre']) || empty($_REQUEST['art_nombre']) || empty($_REQUEST['art_cantidad'])|| $_REQUEST['art_cantidad']<=0)
                    $errores['articulo'] = "* Articulo: Error";                    
                if (empty($errores)) {
                    //añadimos los campos de articulo para luego poder guardar mediante el metodo save a la base datos, ponemos los nombres en mayusculas
                    $articulo->setArt_nombre(strtoupper($_REQUEST['art_nombre']));
                    $articulo->setArt_categoria($_REQUEST['art_categoria']);
                    $articulo->setArt_cantidad($_REQUEST['art_cantidad']);
                    $articulo->save();

                    // Finalmente llama al método listar para que devuelva vista con listado
                    header("Location: index.php?controlador=articulo&accion=listar");
                }
            }

            // Si no recibe el item para añadir, devuelve la vista para añadir un nuevo articulo
            $this->view->show("nuevoView.php", array('errores' => $errores));



        }

        // Método que procesa la petición para editar un articulo
        public function editar()
        {

            require 'models/ArticuloModel.php';
            $articulos = new ArticuloModel();

            // Recuperar el articulo con el id recibido
            $articulo = $articulos->getById($_REQUEST['art_id']);

            if ($articulo == null) {
                $this->view->show("errorView.php", array('error' => 'No existe codigo'));
                
            }

            $errores = array();

            // Si se ha pulsado el botón de actualizar
            if (isset($_REQUEST['submit'])) {

                if (!isset($_REQUEST['art_nombre']) || empty($_REQUEST['art_nombre']))
                    $errores['articulo'] = "* Articulo: Error";

                if (empty($errores)) {
                    //añadimos los campos de articulo para luego poder guardar mediante el metodo save a la base datos, al tener un id, hará un update
                    $articulo->setArt_nombre($_REQUEST['art_nombre']);
                    $articulo->setArt_categoria($_REQUEST['art_categoria']);
                    $articulo->setArt_cantidad($_REQUEST['art_cantidad']);
                    $articulo->save();

                    // Reenvía a la aplicación a la lista de items
                    header("Location: index.php?controlador=articulo&accion=listar");
                }
            }

            // Si no se ha pulsado el botón de actualizar se carga la vista para editar el item
            $this->view->show("editarView.php", array('articulo' => $articulo, 'errores' => $errores));



        }

        // Método para borrar un articulo 
        public function borrar()
        {
            //Incluye el modelo que corresponde
            require_once 'models/ArticuloModel.php';

            //Creamos una instancia de nuestro "modelo"
            $articulos = new ArticuloModel();

            // Recupera el item con el código recibido por GET o por POST
            $articulo = $articulos->getById($_REQUEST['art_id']);

            if ($articulo == null) {
                $this->view->show("errorView.php", array('error' => 'No existe codigo'));
            } else {
                // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación            
                $articulo->delete();
                header("Location: index.php");
            }
        }


        









    }













?>
<?php
    class CategoriaModel{

        //conexión a la base de datos
        protected $db;

        //un campo por cada campo de la tabla articulo
        private $CAT_ID;
        private $CAT_NOMBRE;

        // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
        public function __construct()
        {
            //Traemos la única instancia de PDO
            $this->db = SPDO::singleton();
        }

        


        //getters y setters

        /**
         * Get the value of cat_id
         */ 
        public function getCat_id()
        {
                return $this->CAT_ID;
        }

        /**
         * Set the value of cat_id
         *
         * 
         */ 
        public function setCat_id($cat_id)
        {
                $this->CAT_ID = $cat_id;

                
        }

        /**
         * Get the value of cat_nombre
         */ 
        public function getCat_nombre()
        {
                return $this->CAT_NOMBRE;
        }

        /**
         * Set the value of cat_nombre
         *
         * 
         */ 
        public function setCat_nombre($cat_nombre)
        {
                $this->CAT_NOMBRE = $cat_nombre;

                
        }

        //método para devolver todos los elementos de la tabla categoria
        public function getAll()
        {
            //realizamos una consulta de todos las categorias
            $consulta=$this->db->prepare("SELECT * FROM categoria");
            $consulta->execute();
            $resultado=$consulta->fetchAll(PDO::FETCH_CLASS,"CategoriaModel");
            
            //devolvemos la colección para que la vista la presente.
            return $resultado;
        }


        public function getById($cat_id)
        {
            //devolvemos una consulta preparada por el id de la tabla()
            $gsent = $this->db->prepare('SELECT * FROM categoria where CAT_ID = ?');
            $gsent->bindParam(1, $cat_id);
            $gsent->execute();

            $gsent->setFetchMode(PDO::FETCH_CLASS, "CategoriaModel");
            $resultado = $gsent->fetch();

            return $resultado;
        }

        // Método que almacena en BD un objeto CategoriaModel
        // Si tiene ya código actualiza el registro y si no tiene lo inserta
        public function save()
        {
            if (!isset($this->CAT_ID)) {
                $consulta = $this->db->prepare('INSERT INTO categoria (CAT_NOMBRE ) VALUES (?)');
                $consulta->bindParam(1, $this->CAT_NOMBRE);
                
                $consulta->execute();
            } else {
                $consulta = $this->db->prepare('UPDATE categoria SET CAT_NOMBRE = ? WHERE CAT_ID = ?');
                $consulta->bindParam(1, $this->CAT_NOMBRE);                
                $consulta->bindParam(2, $this->CAT_ID);
                $consulta->execute();
            }
        }

        // Método que elimina el CategoriaModel de la BD
        public function delete()
        {
            //dejamos que se borre la categoría si no hay un elemento asociado
            if($this->articulosAsociados()==0)
            {
                $consulta = $this->db->prepare('DELETE FROM  categoria WHERE CAT_ID =  ?');
                $consulta->bindParam(1, $this->CAT_ID);
                $consulta->execute();
                
            }
           
        }

        private function articulosAsociados()
        {
            //vemos la cantidad de articulos que hay asociados a esa categoria
            $consulta=$this->db->prepare('SELECT * FROM ARTICULO WHERE ART_categoria=?');
            $consulta->bindParam(1, $this->CAT_ID);
            $consulta->execute();
            $cantidad=$consulta->rowCount();
            return $cantidad;   



        }

    }



?>
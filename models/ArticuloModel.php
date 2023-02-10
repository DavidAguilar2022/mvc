<?php

class ArticuloModel{

    //conexión a la base de datos
    protected $db;

    //un campo por cada campo de la tabla articulo
    private $ART_ID;
    private $ART_NOMBRE;
    private $ART_CATEGORIA;
    private $ART_CANTIDAD;


    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    



    /**
     * Get the value of art_id
     */ 
    public function getArt_id()
    {
        return $this->ART_ID;
    }

    /**
     * Set the value of art_id
     *
     * 
     */ 
    public function setArt_id($ART_ID)
    {
        $this->ART_ID = $ART_ID;

        
    }

    /**
     * Get the value of art_nombre
     */ 
    public function getArt_nombre()
    {
        return $this->ART_NOMBRE;
    }

    /**
     * Set the value of art_nombre
     *
     * 
     */ 
    public function setArt_nombre($ART_NOMBRE)
    {
        $this->ART_NOMBRE = $ART_NOMBRE;

        
    }

    /**
     * Get the value of art_categoria
     */ 
    public function getArt_categoria()
    {
        return $this->ART_CATEGORIA;
    }

    /**
     * Set the value of art_categoria
     *
     * 
     */ 
    public function setArt_categoria($ART_CATEGORIA)
    {
        $this->ART_CATEGORIA = $ART_CATEGORIA;

        
    }

    /**
     * Get the value of art_cantidad
     */ 
    public function getArt_cantidad()
    {
        return $this->ART_CANTIDAD;
    }

    /**
     * Set the value of art_cantidad
     *
     *
     */ 
    public function setArt_cantidad($ART_CANTIDAD)
    {
        $this->ART_CANTIDAD = $ART_CANTIDAD;

        
    }


    //método para devolver todos los elementos de la tabla articulo
    public function getAll()
    {
        //realizamos una consulta de todos los articulos
        $consulta=$this->db->prepare("SELECT * FROM ARTICULO");
        $consulta->execute();
        $resultado=$consulta->fetchAll(PDO::FETCH_CLASS,"ArticuloModel");
        
        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    public function getById($art_id)
    {
        //devolvemos una consulta preparada por el id de la tabla()
        $gsent = $this->db->prepare('SELECT * FROM ARTICULO where ART_ID = ?');
        $gsent->bindParam(1, $art_id);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "ArticuloModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }


    // Método que almacena en BD un objeto ArticuloModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->ART_ID)) {            
            $consulta = $this->db->prepare('INSERT INTO ARTICULO ( ART_NOMBRE,ART_CATEGORIA,ART_CANTIDAD ) values ( ?,?,? )');
            $consulta->bindParam(1, $this->ART_NOMBRE);
            $consulta->bindParam(2,$this->ART_CATEGORIA);
            $consulta->bindParam(3,$this->ART_CANTIDAD);
            $consulta->execute();
        } else {
            $consulta = $this->db->prepare('UPDATE ARTICULO SET ART_NOMBRE = ?,ART_CATEGORIA=?,ART_CANTIDAD=? WHERE ART_ID =  ? ');
            $consulta->bindParam(1, $this->ART_NOMBRE);
            $consulta->bindParam(2, $this->ART_CATEGORIA);
            $consulta->bindParam(3, $this->ART_CANTIDAD);
            $consulta->bindParam(4, $this->ART_ID);
            $consulta->execute();
        }
    }

    // Método que elimina el ArticuloModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM  ARTICULO WHERE ART_ID =  ?');
        $consulta->bindParam(1, $this->ART_ID);
        $consulta->execute();
    }









}







?>
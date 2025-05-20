<?php
namespace App\Models;
 
class UserMenu 
{
    // Propiedades del modelo
    private $user;
    private $name;
    private $description;
    private $display_name;
    private $id_wp;
    private $ruta_fisica; 
    private $id; 
    private $menu ;

    // Constructor vacío o con parámetros opcionales
    public function __construct(
        $id = null,  
        $menu = null , 
        $user = null,
        $name = null,
        $description = null,
        $display_name = null,
        $id_wp = null,
        $ruta_fisica = null
    ) {
        $this->id = $id;
        $this->menu = $menu;
        $this->user = $user;
        $this->name = $name;
        $this->description = $description;
        $this->display_name = $display_name;
        $this->id_wp = $id_wp;
        $this->ruta_fisica = $ruta_fisica;
    }

    // Getters y Setters
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDisplayName()
    {
        return $this->display_name;
    }

    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }

    public function getIdWp()
    {
        return $this->id_wp;
    }

    public function setIdWp($id_wp)
    {
        $this->id_wp = $id_wp;
    }

    public function getRutaFisica()
    {
        return $this->ruta_fisica;
    }

    public function setRutaFisica($ruta_fisica)
    {
        $this->ruta_fisica = $ruta_fisica;
    }
    private function setId($id) {
        $this->id = $id;
    }
   private function setMenu($menu) {
        $this->menu = $menu;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getMenu()
    {
        return $this->menu;
    }
    /**
     * Crear un objeto MenuModel desde un array asociativo.
     *
     * @param array $data Array asociativo con las claves correspondientes a las propiedades.
     * @return MenuModel Instancia de MenuModel.
     */
    public static function fromArray(array $data)
    {
        $model = new self();

        $model->setUser($data['user'] ?? null);
        $model->setName($data['name'] ?? null);
        $model->setDescription($data['description'] ?? null);
        $model->setDisplayName($data['display_name'] ?? null);
        $model->setIdWp($data['id_wp'] ?? null);
        $model->setRutaFisica($data['ruta_fisica'] ?? null);
        $model->setId($data['id'] ?? null);
        $model->setMenu($data['menu'] ?? null);

        return $model;
    }
}

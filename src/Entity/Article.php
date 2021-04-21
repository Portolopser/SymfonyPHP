<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
//Para crear una entidad usamos este comando en la terminal php bin/console make:entity *nombredelaentidad*
/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
//Si escribimos *php bin/console doctrine:migrations:diff* y *php bin/console doctrine:migrations:diff* 
//en la terminal se nos crea en la base de datos las entidades como tablas con sus campos
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Creando el campo título
     * @ORM\Column(type="text", length=100)
     */
    private $title;
    
    //Getter y setters de title
    public function getTitle( ){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    /**
     * Creando el campo body
     * @ORM\Column(type="text")
     */
    private $body;

    //Getters y setters de body
    public function getBody( ){
        return $this->body;
    }

    public function setBody($body){
        $this->body = $body;
    }
    
}

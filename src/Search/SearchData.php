<?php
namespace App\Search;

use App\Entity\Genre;
use App\Entity\Auteur;


class SearchData
{
    /**
     *
     * @var string
     */
    public $keyword;

   /**
    *
    * @var Auteur[]
    */
    public $auteurs = [];

    /**
     *
     * @var Genre
     */
    private $genre;


    /**
     * Get the value of keyword
     *
     * @return  string
     */ 
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set the value of keyword
     *
     * @param  string  $keyword
     *
     * @return  self
     */ 
    public function setKeyword(string $keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    // /**
    //  * @return Auteur[]
    //  */
    // public function getAuteurs()
    // {
    //     return $this->auteurs;
    // }

    // /**
    //  *
    //  * @param  Auteur[]  $auteurs
    //  *
    //  * @return  self
    //  */ 
    // public function setAuteurs(Auteur $auteurs)
    // {
    //     $this->auteurs = $auteurs;

    //     return $this;
    // }

    /**
     *
     * @return Genre|null
     */
    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    /**
     *
     * @param Genre|null $genre
     * @return self
     */
    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }


}

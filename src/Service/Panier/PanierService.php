<?php
namespace App\Service\Panier;

use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{
    private $session;
    private $livreRepository;

    public function __construct(SessionInterface $session, LivreRepository $livreRepository)
    {
        $this->session = $session;
        $this->livreRepository = $livreRepository;
    }

    /**
     * Ajoute à notre panier (la session) un tableau représentant
     * id du livre et l'objet Livre
     *
     * @param integer $id
     */
    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);
        $panier[$id] = $this->livreRepository->find($id);
        $this->session->set('panier', $panier);
    }

    /**
     * Supprime le livre de notre panier(la session)
     *
     * @param integer $id
     */
    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id]))
        {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    /**
     * Récupère le panier (session)
     */
    public function show()
    {
        return $this->session->get('panier', []);
    }
    
}

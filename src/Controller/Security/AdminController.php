<?php 

namespace App\Controller\Security ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    
    /**
     * 
     *@Route("/login_admin", name="login_admin")
     * 
     */
    public function adminLogin(AuthenticationUtils $au)
    {
        $error = $au->getLastAuthenticationError();
        $lastUsername = $au->getLastUsername();
        return $this->render('security/login_admin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'active_login' => 'actived'
        ]);
    }

     /**
     * 
     *@Route("/admin/gestion", name="gestion_admin")
     * 
     */
    public function adminGestion()
    {
        return $this->render('admin/gestion/index.html.twig');
    }

}

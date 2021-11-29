<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EngagementsController extends AbstractController
{


    /**
     * @Route("/engagements" , name="nos_engagements")
     */
    public function index()
    {


        return $this->render("engagements/index.html.twig"); 
    }





}
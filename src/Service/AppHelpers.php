<?php

namespace App\Service;


use App\Entity\Carousel;
use App\Entity\Categorie;
use App\Entity\Produit;
use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

class AppHelpers
{
  private $params;
  private $doctrine;
  private $security;
  private $db;

  public function __construct(ContainerBagInterface $params, ManagerRegistry $doctrine, Security $security)
  {
    $this->params = $params;
    $this->doctrine = $doctrine;
    $this->db = $doctrine->getManager();
    $this->security = $security;
  }

  public function getUser()
  {
    $user = $this->security->getUser();
    if ($user) {
      $isLoggedIn = true;
    } else {
      $isLoggedIn = false;
    }
    if ($this->security->isGranted('ROLE_ADMIN')) {
      $isAdmin = true;
    } else {
      $isAdmin = false;
    }
    $userObj = new stdClass();
    $userObj->user = $user;
    $userObj->isAdmin = $isAdmin;
    $userObj->isLoggedIn = $isLoggedIn;
    return $userObj;
  }

  public function getBodyId(string $page): string
  {
    return $this->params->get($page);
  }
}

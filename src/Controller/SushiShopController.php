<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Entity\ShopItem;
use App\Repository\GunkanRepository;
use App\Repository\SashimiRepository;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SushiShopController extends AbstractController
{
    private SessionInterface $session;

    /**
     * SushiShopController constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
        $this->session->set('flag', '1');
    }


    /**
     * @Route("/sushi", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'SushiShopController',
        ]);
    }
    /**
     * @Route("/sushi/list", name="shopList")
     * @return Response
     */
    public function shopList(ShopItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();

        return $this->render('index/shopList.html.twig', [
            'title' => 'SUSHI',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/sushi/cart/add/{item<\d+>}", name="shopCartAdd")
     * @param ShopItem $item
     * @return Response
     */
    public function shopCartAdd(ShopItem $item): Response
    {
        $em = $this->getDoctrine()->getManager();//
        $sessionID = $this->session->getId();
        $shopCart = (new ShopCart())
            ->setItemsList($item)
            ->setSessionID($sessionID);
        $em->persist($shopCart);
        $em->flush();
        return $this->redirectToRoute('shopItem', ['id'=>$item->getID()]);
    }

    /**
     * @Route("/sushi/cart/delete", name="shopCartDelete")
     * @return Response
     */
    public function shopCartClean(): Response
    {
//       $entityManager = $this->getDoctrine()->getManager();
//       $entityManager->remove($item);
//       $entityManager->flush();
       $this->session->migrate();
       return $this->redirectToRoute('shopList');
    }

    /**
     * @Route("/sushi/cart/count}", name="shopCartCount")
     * @return Response
     */
    public function countCalories(): Response
    {
        $itemRepository = new ShopItemRepository();

        $em = $this->getDoctrine()->getManager();
        $calories = 0;
        $items = $itemRepository->findAll();
        foreach($items as $item){
            $item_type = $item->getType();
            $item_type_id = $item->getTypeId();
            ($item_type == "gunkan")? $repository = new GunkanRepository() : $repository = new SashimiRepository();
            $calories = $calories + $repository->find($item_type_id)->getCalories();
        }
        return $this->redirectToRoute('shopCart', ['calories'=>$calories]);
    }
    /**
     * @Route("/sushi/item/{item<\d+>}", name="shopItem")
     * @param ShopItem $item
     * @return Response
     */
    public function shopItem(ShopItem $item): Response
    {
        return $this->render('index/shopItem.html.twig', [
            'title' => $item->getTitle(),
            'price' => $item->getPrice(),
            'id' => $item->getId(),
        ]);
    }

    /**
     * @Route("/sushi/cart", name="shopCart")
     * @param ShopCartRepository $cartRepository
     * @return Response
     */
    public function shopCart(ShopCartRepository $cartRepository): Response
    {
        $session = $this->session->getId();
        $items = $cartRepository->findBy(['sessionID'=>$session]);

        return $this->render('index/shopCart.html.twig', [
            'title' => 'CART',
            'items'=>$items,
        ]);
    }

}

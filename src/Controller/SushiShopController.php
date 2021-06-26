<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Entity\ShopItem;
use App\Entity\Gunkan;
use App\Entity\Sashimi;
use App\Repository\CartItemRepository;
use App\Repository\GunkanRepository;
use App\Repository\SashimiRepository;
use App\Repository\ShopCartRepository;
use App\Repository\ShopItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

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
     * @Route("/index", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'SushiShopController',
        ]);
    }

    /**
     * @Route("/list", name="shopList")
     * @return Response
     */
    public function shopList(): Response
    {
//        ShopItemRepository $itemRepository

        $itemRepository = $this->getDoctrine()->getRepository(ShopItem::class);
        $items = $itemRepository->findAll();

        return $this->render('index/shopList.html.twig', [
            'title' => 'SUSHI',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/cart/add/{item<\d+>}", name="shopCartAdd")
     * @param ShopItem $item
     * @return Response
     */
    public function shopCartAdd(ShopItem $item): Response
    {
        $em = $this->getDoctrine()->getManager();//
        $sessionID = $this->session->getId();
        $cal = 0;
        if ($em->getRepository(ShopCart::class)->findBy(['sessionID' => $sessionID]) == null) {
            $shopCart = (new ShopCart());
            $shopCart->setSessionID($sessionID);
            $shopCart->addItemList($item);
            $shopCart->setAllCal($cal);
            $em->persist($shopCart);
        } else {
            $already_ex = $em->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->getItemList();
            $flag = true;
            foreach ($already_ex as $it){
                if ($it->getId() == $item->getId()) $flag = false;
            }
            if ($flag) $em->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->addItemList($item);
        }
        $em->flush();
        return $this->redirectToRoute('shopItem', ['id' => $item->getID()]);
    }

    /**
     * @Route("/delete", name="shopCartDelete")
     * @return Response
     */
    public function shopCartClean(): Response
    {
        $sessionID = $this->session->getId();
        $entityManager = $this->getDoctrine()->getManager();
        if ($entityManager->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID]) != null) {
            $entityManager->remove($entityManager->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID]));
            $entityManager->flush();
        }
        $this->all_calories = 0;
        return $this->redirectToRoute('shopList');
    }

    /**
     * @Route("/cart/count", name="shopCartCount")
     * @return Response
     */
    public function countCalories(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $calories = 0;
        $sessionID = $this->session->getId();

        if ($em->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID]) != null) {
            $items_in_cart = $em->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->getItemList();

            foreach ($items_in_cart as $item) {
                $item_type = $item->getType();
                $item_type_id = $item->getTypeId();

                ($item_type == "gunkan") ? $repository = $em->getRepository(Gunkan::class)->find(['id'=>$item_type_id]) : $repository = $em->getRepository(Sashimi::class)->find(['id'=>$item_type_id]);
                $calories = $calories + $repository->getCalories();
            }
            $em->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->setAllCal($calories);
            $em->flush();
        }
        $this->all_calories = $calories;


        return $this->redirectToRoute('shopCart');
    }

    /**
     * @Route("/item/{id<\d+>}", name="shopItem")
     * @param ShopItem $item
     * @return Response
     */
    public function shopItem(ShopItem $item): Response
    {
        return $this->render('index/shopItem.html.twig', [
            'title' => $item->getTitle(),
            'type' => $item->getType(),
            'price' => $item->getPrice(),
            'id' => $item->getId(),
            'image_id' => $item->getId(),
        ]);
    }

    /**
     * @Route("/cart", name="shopCart")
     * @return Response
     */
    public function shopCart(): Response //ShopCartRepository $cartRepository
    {
        $sessionID = $this->session->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $calories = 0;
        if ($entityManager->getRepository(ShopCart::class)->findBy(['sessionID' => $sessionID]) != null) {
            $calories = $entityManager->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->getAllCal();

            $items = $entityManager->getRepository(ShopCart::class)->findOneBy(['sessionID' => $sessionID])->getItemList();
        } else $items = [];

        return $this->render('index/shopCart.html.twig', [
            'title' => 'CART',
            'items' => $items,
            'calories' => $calories,
        ]);
    }

}

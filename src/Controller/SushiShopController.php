<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Entity\ShopItem;
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
     * @Route("/", name="index")
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
        if (!$em->getRepository(ShopCart::class)->findBy(['sessionID'=>$sessionID]).isEmpty()){
            $shopCart = (new ShopCart())
                ->addItemList($item)
                ->setSessionID($sessionID);
            $em->persist($shopCart);
            $em->flush();
        }else{
            $em->getRepository(ShopCart::class)->findOneBy(['sessionID'=>$sessionID])->addItemList($item);
        }
        return $this->redirectToRoute('shopItem', ['id'=>$item->getID()]);
    }

    /**
     * @Route("/cart/delete", name="shopCartDelete")
     * @return Response
     */
    public function shopCartClean(): Response
    {
       $sessionID = $this->session->getId();
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->remove($entityManager->getRepository(ShopCart::class)->findOneBy(['sessionID'=>$sessionID]));
       $entityManager->flush();
       return $this->redirectToRoute('shopList');
    }

    /**
     * @Route("/cart/count}", name="shopCartCount")
     * @return Response
     */
    public function countCalories(): Response
    {
        $itemRepository = new ShopItemRepository();

        $em = $this->getDoctrine()->getManager();
        $calories = 0;
        $items = $em->getRepository(ShopItem::class)->findAll();
        foreach($items as $item){
            $item_type = $item->getType();
            $item_type_id = $item->getTypeId();

            $class_name = ($item_type == "gunkan")? "Gunkan" : "Sashimi";
            $repository = $em->getRepository($class_name."Repository::class");
            $calories = $calories + $repository->find($item_type_id)->getCalories();
        }
        return $this->redirectToRoute('shopCart', ['calories'=>$calories]);
    }
    /**
     * @Route("/item}", name="shopItem")
     * @param ShopItem $item
     * @return Response
     */
    public function shopItem(ShopItem $item): Response
    {
        return $this->render('index/shopItem.html.twig', [
            'title' => $item->getTitle(),
            'price' => $item->getPrice(),
            'id' => $item->getId(),
            'image_id'=>$item->getId(),
        ]);
    }

    /**
     * @Route("/cart", name="shopCart")
     * @param CartItemRepository $cartItemRepository
     * @return Response
     */
    public function shopCart(ShopCartRepository $cartRepository): Response
    {
        $session = $this->session->getId();
        $items = $cartRepository->findBySessionID($session)->getItemList();
        return $this->render('index/shopCart.html.twig', [
            'title' => 'CART',
            'items' => $items,
            'calories' => 0,
        ]);
    }

}

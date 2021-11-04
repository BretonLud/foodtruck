<?php

    namespace App\Controller\Admin;


    use App\Entity\Order;
    use App\Form\OrderType;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use App\Repository\OrderRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    Use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

    /**
     * @Route("/admin/order", name="admin_")
     */
    class AdminCartController extends AbstractController
    {
        /**
         * @var OrderRepository
         */
        private $orderRepository;

        /**
         * @var EntityManagerInterface
         */
        private $em;

        /**
         * @var Order
         */
        private $order;

        /**
         * @param EntityManagerInterface $em
         * @param OrderRepository $orderRepository
         * @param Order $order
         */
        public function __construct(EntityManagerInterface $em, OrderRepository $orderRepository, Order $order)
        {
            $this->em = $em;
            $this->orderRepository = $orderRepository;
            $this->order = $order;
        }

        /**
         * @return Response
         * @Route("/", name="cart_index")
         */
        public function index(): Response
        {
            return $this->render('/admin/cart/index.html.twig');
        }

        /**
         * @param Request $request
         * @param Order $order
         * @return Response
         * @Route("/wait/", name="cart_wait")
         */
        public function ordersWait(Request $request): Response
        {

            $orders = $this->orderRepository->findCommand();

            if($request->isMethod('POST')) {
                $checks = $request->request->get('check');

                if (!empty($checks)) {

                    foreach ($checks as $check) {
                        $order = $this->orderRepository->findOneBy(["reference" => $check]);

                        $order->setChecked(true);
                        $this->em->persist($order);
                    }
                        $this->em->flush();
                    $orders = $this->orderRepository->findCommand();

                    return $this->render('/admin/cart/wait.html.twig', [
                        'orders' => $orders,
                    ]);

                }
            }
            return $this->render('/admin/cart/wait.html.twig', [
                'orders' => $orders
            ]);
        }

        /**
         * @return Response
         * @Route("/past", name="cart_past")
         */
        public function odersPast()
        {
            $orders = $this->orderRepository->findPastComand();

            return $this->render('/admin/cart/past.html.twig', [
                'orders' => $orders
            ]);
        }
    }
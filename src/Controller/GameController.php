<?php

namespace App\Controller;


use App\Model\Armoury;
use App\Model\Buildings\Castle;
use App\Model\Buildings\Farm;
use App\Model\Buildings\House;
use App\Model\Town;
use App\Model\Weapons\Trebuchet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var Town|null
     */
    private $town;
    /**
     * @var Armoury|null
     */
    private $armoury;

    public function __construct(SessionInterface $session)
    {

        // using Symfonys Session system
        // Get the session with the key town if it exists, otherwise return null
        // do the same with our armoury which stores all the weapons


        $this->session = $session;
        $this->town = $this->session->get('town', null);
        $this->armoury = $this->session->get('armoury', null);
    }

    /**
     * @Route("/game/start", name="GameStart")
     * @return Response
     */
    public function start()
    {
        $this->newGame();
        return $this->redirectToRoute('Game');
    }

    /**
     * @Route("/game", name="Game")
     * @return Response
     */
    public function index()
    {
        if (!$this->town) {
            $this->newGame();
        }

        return $this->render('game/index.html.twig', [
            'town' => $this->town,
            'armoury' => $this->armoury
        ]);
    }


    /**
     * @Route("/game/attack", name="GameAttack")
     */
    public function attack(Request $request)
    {

        if (!$this->town) {
            $this->newGame();
            return $this->redirectToRoute('Game');
        }

        if($this->town->isObjectiveMet()){
            return $this->redirectToRoute('Game');
        }

        $this->town->incrementTurn();

        if ($request->isMethod('post')) {
            // get the weapon id from the post data
            $weaponId = $request->get('weapon', false);

            // check weapon id matches an existing weapon, if so use it
            if ($weapon = $this->armoury->getWeapon($weaponId)) {
                $this->town->attackRandomBuilding($weapon);
            } else {
                //todo alert the user that no weapon was used
            }
        }

        //redirect to game view, just so we don't keep hitting f5
        return $this->redirectToRoute('Game');
    }

    private function newGame()
    {
        $this->town = new Town();
        $this->town
            ->addBuilding(new Castle())
            ->addBuilding(new House())
            ->addBuilding(new House())
            ->addBuilding(new House())
            ->addBuilding(new Farm())
            ->addBuilding(new Farm())
            ->addBuilding(new Farm());
        $this->session->set('town', $this->town);

        $this->armoury = new Armoury();
        $this->armoury->addWeapon(new Trebuchet());

        $this->session->set('armoury', $this->armoury);
    }
}
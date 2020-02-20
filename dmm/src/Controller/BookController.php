<?php

namespace App\Controller;

use App\Services\Book_api\BookServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/search", name="book")
     */
    public function search(BookServices $bookServices, Request $request)
    {
        if (!empty($request->get('search'))) {

            dump($result = $bookServices->search($request));
        } else {
            $result = false;
        }
        return $this->render('default/search.html.twig', ['result' => $result]);
    }
}

<?php


namespace App\Services\book_api;


use Google_Client;
use Google_Service_Books;
use Symfony\Component\HttpFoundation\Request;
use Apikey;

class bookServices
{

    public function search(Request $request){
    $client = new Google_Client();
    $client->setApplicationName("Library_book");
    $apikey = new Apikey();
    $client->setDeveloperKey($apikey->apibook());
    $service = new Google_Service_Books($client);
    $results = $service->volumes->listVolumes($request->get('search'));

    return $results;
}
}
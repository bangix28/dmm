<?php


namespace App\Services\Book_api;


use Google_Client;
use Google_Service_Books;
use Symfony\Component\HttpFoundation\Request;
use Apikey;

class BookServices
{

    public function search(Request $request){
    $client = new Google_Client();
    $client->setApplicationName("Library_book");
    $apikey = new Apikey();
    $client->setDeveloperKey($apikey->apibook());
    $service = new Google_Service_Books($client);
    $optParams = array(
        'orderBy' => "relevance",
        'printType' => "books",

        'langRestrict' => "fr",
        'q' => 'intitle:'. $request->get('search') . ''
    );
    $results = $service->volumes->listVolumes('q', $optParams);

    return $results;
}
}
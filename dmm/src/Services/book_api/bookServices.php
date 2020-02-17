<?php


namespace App\Services\book_api;


use Google_Client;
use Google_Service_Books;

class bookServices
{


    public function search(){
    $client = new Google_Client();
    $client->setApplicationName("Library_book");
    $client->setDeveloperKey("..");

    $service = new Google_Service_Books($client);
    dump($results = $service->volumes->listVolumes(' hugo'));

    return $results;
}
}
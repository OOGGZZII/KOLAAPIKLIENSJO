<?php
namespace App\Interfaces;
interface ClientInterface {

//  function createUrl($path, array $query = []);

//  function exec($url);

//  static function getResult($response, $curl, $url);

  function post($url, array $data = []);

  function get($url, array $query = []);

  function delete($url, $id);

  function put($url, array $data = []);

  function update($url, array $data = []);

}

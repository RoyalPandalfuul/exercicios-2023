<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use DOMXPath;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    $papers = [];
    $aux = 0;

    $xpath = new DOMXPath($dom);
    $paper_elements = $xpath->query('//*[contains(@class, "paper-card")]');

    foreach($paper_elements as $paper){
      $arr_authors = [];

      $paper_title = $xpath->query('//*[contains(@class, "paper-title")]', $paper)->item($aux)->textContent;

      $paper_id = $xpath->query('//*[contains(@class, "volume-info")]', $paper)->item($aux)->textContent;

      $paper_type = $xpath->query('//div[@class="tags mr-sm"]', $paper)->item($aux)->textContent;
      
      $author_node = $xpath->query('.//div[@class="authors"]/span[@title]', $paper);
      
      foreach ($author_node as $author) {
        $author_name = $author->nodeValue;
        $author_institution = $author->getAttribute('title');
        $arr_authors[] = new Person($author_name, $author_institution);
      }

      $paper_instance = new Paper($paper_id, $paper_title, $paper_type, $arr_authors);
      $papers[] = $paper_instance;
      
      $aux++;
    }

    return $papers;
  }

}

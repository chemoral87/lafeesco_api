<?php
namespace App\Services;

use App\Models\Bible;
use App\Models\BibleBook;

class BibleService {

  public function getVersicles($search) {
    $prompts = explode(";", $search);
    foreach ($prompts as $prompt) {
      $data[] = $this->getComponents($prompt);
    }
    return $data;
  }

  public function getComponents($prompt) {

    $verseTo = "";
    $patron_1 = "/(\d+)\s*(\w+)\s(\d+)\.(\d+)-(\d+)/";
    // ex 1 jn 1.1-3
    if (preg_match($patron_1, $prompt, $match)) {
      //   $num = $match[1];
      $book = $match[1] . " " . $match[2];
      $chapter = $match[3];
      $verse = $match[4];
      $verseTo = $match[5];
    }

    $patron_3 = "/(\d+)\s*(\w+)\s(\d+)\.(\d+)/";
    // ex 1 jn 1.1
    if (preg_match($patron_3, $prompt, $match)) {
      //   $num = $match[1];
      $book = $match[1] . " " . $match[2];
      $chapter = $match[3];
      $verse = $match[4];
    }

    $patron_2 = "/(\w+)\s(\d+)\.(\d+)-(\d+)/";
    // ex jn 1.1-3
    if (preg_match($patron_2, $prompt, $match)) {
      //   $num = $match[1];
      $book = $match[1];
      $chapter = $match[2];
      $verse = $match[3];
      $verseTo = $match[4];
    }

    $patron_4 = "/(\w+)\s(\d+)\.(\d+)/";
    // ex jn 1.1-3
    if (preg_match($patron_4, $prompt, $match)) {
      //   $num = $match[1];
      $book = $match[1];
      $chapter = $match[2];
      $verse = $match[3];
    }

    if (!isset($book)) {
      return "no " . $prompt;
    }

    $bible_book = BibleBook::where("name", "like", $book . "%")->orderBy("name", "asc")->first();

    $query = Bible::query();
    $query->where("book", $bible_book->id)
      ->where("chapter", $chapter)
    //   ->whereBetween("verse", [$verse, $verseTo])
      ->orderBy("verse", "asc");

    if ($verseTo == "") {
      $query->where("verse", $verse);
    } else {
      $query->whereBetween("verse", [$verse, $verseTo]);
    }

    $versicles = $query->get();

    return [
      'book' => $bible_book,
      'chapter' => $chapter,
      'verse' => $verse,
      'verseTo' => $verseTo,
      'versicles' => $versicles,
    ];
  }

}

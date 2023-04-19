<?php
namespace App\Services;

use App\Models\Bible;
use App\Models\BibleBook;

class BibleService {

  public function getVersicles($search) {
    $prompts = explode(";", $search);
    foreach ($prompts as $prompt) {
      if (isset($prompt) && $prompt != "") {
        $data[] = $this->getComponents($prompt);
      }

    }
    return $data;
  }

  public function getComponents($prompt) {

    $verseTo = "";
    // $patron_1 = "/^(\d+\s*)?(\w+)\s(\d+)\.(\d+)-(\d+)/";
    $patron_1 = "/^(\d+\s*)?(\w+)\s(\d+)\.(\d+)?(?:-(\d+))?$/i";

    // ex 1 jn 1.1-3
    if (preg_match($patron_1, $prompt, $match)) {
      //   Log::info("patron_1");
      //   Log::info($match);
      $num = $match[1];
      $book = trim($match[1]) . " " . $match[2];
      $chapter = $match[3];
      $verse = $match[4];
      $verseTo = isset($match[5]) ? $match[5] : "";
    }

    if (!isset($book)) {
      return [
        'prompt' => $prompt];
    }
    // Log::info($book);
    $bible_book = BibleBook::where("name", "like", trim($book) . "%")->orderBy("name", "asc")->first();

    if (!isset($bible_book->id)) {
      return [
        'prompt' => $prompt];
    }

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

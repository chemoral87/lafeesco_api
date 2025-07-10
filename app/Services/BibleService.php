<?php
namespace App\Services;

use App\Models\Bible;
use App\Models\BibleBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BibleService {
  public function getVersicles(string $search): array {
    $prompts = explode(";", $search);
    $data = [];

    foreach ($prompts as $prompt) {
      $prompt = trim($prompt);
      if ($prompt !== "") {
        $data[] = $this->getComponents($prompt);
      }
    }

    return $data;
  }

  public function stripAccents(string $str): string {
    // Mejor usar iconv para mayor compatibilidad
    $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    return $str ?: $str; // fallback por si iconv falla
  }

  public function getComponents(string $prompt): array {
    $promptNormalized = $this->stripAccents($prompt);

    // Versión del patrón que hace opcional la parte de versículo
    $pattern = "/^(\d+\s*)?(\w+)\s+(\d+)(?:[.:](\d+)(?:-(\d+))?)?$/i";

    if (!preg_match($pattern, $promptNormalized, $matches)) {
      return ['prompt' => $prompt];
    }

    $num = isset($matches[1]) ? trim($matches[1]) : '';
    $bookNamePart = trim($num . ' ' . $matches[2]);

    $chapter = $matches[3];
    $verse = $matches[4] ?? null; // puede no venir
    $verseTo = $matches[5] ?? null;

    $bookNormalized = Str::lower($bookNamePart);

    Log::info("Normalized book name: $bookNormalized");

    // remove whitespaces bookNormalized
    $bookNormalizedAbbreviation = preg_replace('/\s+/', '', $bookNormalized);

    $bible_book = BibleBook::whereRaw('FIND_IN_SET(?, LOWER(abbreviation))', [$bookNormalizedAbbreviation])->first();

    if (!$bible_book) {
      $bible_book = BibleBook::where('name', 'LIKE', $bookNamePart . '%')->orderBy('name')->first();
    }

    if (!$bible_book) {
      return ['prompt' => $prompt];
    }

    $query = Bible::where('book', $bible_book->id)
      ->where('chapter', $chapter)
      ->orderBy('verse');

    if ($verse === null) {
      // No especificó versículo: devuelve todo el capítulo
      $versicles = $query->get();
    } else {
      if ($verseTo === null) {
        $query->where('verse', $verse);
      } else {
        $start = min($verse, $verseTo);
        $end = max($verse, $verseTo);
        $query->whereBetween('verse', [$start, $end]);
      }
      $versicles = $query->get();
    }

    /* if ($versicles->isEmpty()) {
    return ['prompt' => $prompt];
    } */

    return [
      'book' => $bible_book,
      'chapter' => $chapter,
      'verse' => $verse,
      'verseTo' => $verseTo,
      'prompt' => $prompt,
      'versicles' => $versicles,
    ];
  }

}

<?php
namespace App\Services\Tag;

use App\Models\Tag;

class Service
{
    public static function getTagIdsFromText(string $text): array
    {
        $tags = self::parseTags($text);
        if (count($tags) === 0) return [];

        return self::getOrCrateTagIds($tags);
    }

    private static function getOrCrateTagIds(array $tags): array
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $newTag = Tag::firstOrCreate($tag, $tag);
            $tagIds[] = $newTag->id;
        }
        return $tagIds;
    }

    private static function parseTags(string $str): array
    {
        $keywords = [];
        preg_match_all('/#(\w+)/', $str, $matches);
        foreach ($matches[1] as $match) {
            $keywords[] = [
                'title' => $match
            ];
        }
        return $keywords;
    }

    public static function replaceTagsToLinks($text)
    {
       return preg_replace('/#(\w+)/', ' <a href="/tags/$1">#$1</a>', $text);
    }
}

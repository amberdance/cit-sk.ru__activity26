<?php

namespace App\Lib;

use App\Constants;
use Exception;

class NewsRss
{

    /**
     * @param int|null $limit
     *
     * @return array
     */
    public static function news1777ru(?int $limit = null): array
    {

        try {
            $response = self::parse('https://news.1777.ru/rss/yandex');
            $result   = array_filter($response['channel']['item'], function ($item) {
                return in_array($item['category'], ['Общество', 'Экономика', 'Спорт, отдых']) && !preg_match("/(" . implode('|', Constants::NEWS_CENSORED_WORDS) . ")/", mb_strtolower($item['title']));
            });

            foreach ($result as $i => $item) {
                $result[$i]['id']    = $i;
                $result[$i]['image'] = $item['enclosure'][0]['@attributes']['url'] ?? $item['enclosure']['@attributes']['url'];
            }

            return array_slice($result, 0, $limit ?? 4);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    private static function parse(string $url): array
    {

        $xml = file_get_contents($url, false, stream_context_create(array('https' => array('header' => 'Accept: application/xml'))));
        $xml = json_encode(simplexml_load_string($xml));

        return json_decode($xml, true);

    }
}

<?php

function getCall($url, $parameters)
{
    $client = new GuzzleHttp\Client();

    $res = $client->request('GET', $url, $parameters);

    if ($res->getStatusCode() == '200') {
        return $res;
    }
}

/**
 * remove links from string
 *
 * @param $body
 * @return mixed
 */
function removeLinks($body)
{
    $pattern = '/(<a\s*?href[\s\S]*?>)|(<a[\s]*?class="[\s\S]*?">)/';
    $body = preg_replace($pattern, '', $body);

    $pattern = '/<\/a>/';
    $body = preg_replace($pattern, '', $body);
    return $body;
}

/**
 * Function used to create a slug associated to an "ugly" string.
 *
 * @param string $string the string to transform.
 *
 * @return string the resulting slug.
 */
function createSlug($string) {

    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-'
    );

    // -- Remove duplicated spaces
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

    // -- Returns the slug
    return strtolower(strtr($string, $table));


}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

/**
 * Orientate an image, based on its exif rotation state
 *
 * @param  Intervention\Image\Image $image
 * @param  integer $orientation Image exif orientation
 * @return Intervention\Image\Image
 */
function orientate($image, $orientation)
{
    switch ($orientation) {

        // 888888
        // 88
        // 8888
        // 88
        // 88
        case 1:
            return $image;

        // 888888
        //     88
        //   8888
        //     88
        //     88
        case 2:
            return $image->flip('h');


        //     88
        //     88
        //   8888
        //     88
        // 888888
        case 3:
            return $image->rotate(180);

        // 88
        // 88
        // 8888
        // 88
        // 888888
        case 4:
            return $image->rotate(180)->flip('h');

        // 8888888888
        // 88  88
        // 88
        case 5:
            return $image->rotate(-90)->flip('h');

        // 88
        // 88  88
        // 8888888888
        case 6:
            return $image->rotate(-90);

        //         88
        //     88  88
        // 8888888888
        case 7:
            return $image->rotate(-90)->flip('v');

        // 8888888888
        //     88  88
        //         88
        case 8:
            return $image->rotate(90);

        default:
            return $image;
    }
}
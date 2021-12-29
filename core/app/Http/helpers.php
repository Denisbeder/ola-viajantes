<?php

function sprintf_array($format, $arr)
{
    return call_user_func_array('sprintf', array_merge((array) $format, $arr));
}

function array_filter_recursive($input)
{
    foreach ($input as &$value) {
        if (is_array($value)) {
            $value = array_filter_recursive($value);
        }
    }

    return array_filter($input);
}

function is_mobile()
{
    return app('mobile-detect')->isMobile();
}

function is_html($string)
{
    // Check if string contains any html tags.
    return preg_match('/<\s?[^\>]*\/?\s?>/i', $string);
}

function is_url($url){
    $url = parse_url($url);
    if (!isset($url["host"])) return false;
    return !(gethostbyname($url["host"]) == $url["host"]);
}

// Used on Adverts
function makeUrlFilter(array $parameters)
{
    return request()->url() . '?' . http_build_query($parameters + request()->query());
}

// Used on Adverts
function removeUrlFilter(string $query)
{
    return request()->url() . '?' . http_build_query(request()->except($query));
}

function fileExists($path)
{
    return cache()->rememberForever('fileexists_'.md5($path), function () use ($path) {
        return (@fopen($path, "r")==true);
    });
}

function imageInfos($path, $key = null)
{
    try {
        $infos = cache()->rememberForever('imginfos_'.md5($path), function () use ($path) {
            $img = getImgSize($path);
        
            $infos = [
                'width' => $img[0],
                'height' => $img[1],
                //'mime' => $img->mime(),
                'path' => $path,
            ];
    
            return $infos;
        });
    
        return is_null($key) ? $infos : @$infos[$key];
    } catch (\Exception $e) {
        return null;
    }    
}

function getImgSize($image_url)
{
    $handle = fopen($image_url, "rb");
    $contents = "";
    $count = 0;
    if ($handle) {
        do {
            $count += 1;
            $data = fread($handle, 8192);
            if (strlen($data) == 0) {
                break;
            }
            $contents .= $data;
        } while (true);
    } else {
        return false;
    }
    fclose($handle);
 
    $im = ImageCreateFromString($contents);
    if (!$im) {
        return false;
    }
    $gis[0] = ImageSX($im);
    $gis[1] = ImageSY($im);
    // array member 3 is used below to keep with current getimagesize standards
    $gis[3] = "width=\"{$gis[0]}\" height=\"{$gis[1]}\"";
    ImageDestroy($im);
    return $gis;
}


function banner($position = null, $rand = true)
{
    $query = App\Banner::where('publish', 1);

    if (is_null($position)) {
        $datas = cache()->rememberForever('banner:all', function () use ($query) {
            return $query->get();
        });
    }

    if (is_array($position)) {
        $datas = cache()->rememberForever('banner:' . implode(',', $position), function () use ($query, $position) {
            return $query->whereIn('position', $position)->get();
        });
    }

    $datas = cache()->rememberForever('banner:' . $position, function () use ($query, $position) {
        return $query->where('position', $position)->get();
    });

    if ($rand) {
        return $datas->shuffle();
    }

    return $datas;
}

function format_bytes($bytes, $precision = 2)
{
    if ((bool) !strlen($bytes)) {
        return;
    }

    $units = array('B', 'KB', 'MB', 'GB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1000, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function facebook_access_token()
{
    $token = unserialize(base64_decode(@app('settingService')->get('facebook')['access_token']));

    if ($token && ($token->getExpiresAt() > now() || is_null($token->getExpiresAt()))) {
        return $token;
    }

    return false;
}

<?php

namespace AACS;

class KVCanonicalMerger {
    public static function Merge($map, $keys)
    {
        $toMerge = array_intersect_key($map, array_flip($keys));
        ksort($toMerge);
        $cannonRes = '';
        foreach ($toMerge as $key => $value) {
            $cannonRes .= $key . $value;
        }
        return $cannonRes;
    }
}
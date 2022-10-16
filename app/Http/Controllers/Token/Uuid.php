<?php
namespace App\Http\Controllers\Token;

class Uuid
{
    private $a = 24;
    private $b = 10;
    private $c = 93;

    public function alphabet($string, $encode = true)
    {
        $newCode = '';
        if ($encode) {
            $encodeNumber = (((((($string * $this->a) * $this->b) * $this->c) * $this->a) * $this->b) * $this->c);
            $newCode = $encodeNumber;
        } else {
            $newCode = (((((($string / $this->c) / $this->b) / $this->a) / $this->c) / $this->b) / $this->a);
        }
        return $newCode;
    }

    public function id_encode($id)
    {
        return $this->alphabet($id, true);
    }
    
    public function id_decode($id)
    {
        return $this->alphabet($id, false);
    }

    public function transformer($array, $options)
    {
        if (isset($array[0])) {
            foreach ($array as $key => $value) {
                foreach ($options as $option) {
                    $array[$key][$option] = $this->id_encode($array[$key][$option]);
                }
            }
        } else {
            foreach ($options as $option) {
                $array[$option] = $this->id_encode($array[$option]);
            }
        }
        return $array;
    }
}

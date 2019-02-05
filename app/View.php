<?php

namespace App;

use App\Post;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class View extends Model
{
    protected $fillable = ['post_id', 'url', 'path', 'ipaddress', 'iphash', 'user_agent'];

    /**
     * Encrypt the given string using the CRYPT class.
     * 
     * @param   string $value       Value to encrypt
     * @return  string              Encrypted $value
     * 
     * @author  M. Sax
     * @version 2019-02-05
     */
    public static function encrypt($value)
    {
        return Crypt::encryptString($value);
    }

    /**
     * Decrypt the given string using the CRYPT class.
     * 
     * @param   string $value       Value to decrypt
     * @return  mixed               Decrypted $value or false on DycryptException
     * 
     * @author  M. Sax
     * @version 2019-02-05
     */
    public static function decrypt($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return false;
        }        
    }

    public function getSame($match = "iphash")
    {
        $views = View::all();
        $decrypted = View::decrypt($this->{$match});
        $matches = array();

        foreach ($views as $v) {
            if (View::decrypt($v->{$match}) == $decrypted) {
                $matches[] = $v;
            }
        }

        return $matches;
    }

    /**
     * Defines the relationship between View and Post.
     * One View belongs to one Post.
     * One Post can have many Views.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

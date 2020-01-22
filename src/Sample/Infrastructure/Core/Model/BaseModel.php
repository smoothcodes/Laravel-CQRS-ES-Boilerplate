<?php declare(strict_types=1);

namespace SmoothCode\Sample\Infrastructure\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    public function getAttribute($key)
    {
        return parent::getAttribute(Str::snake($key));
    }

    public function setAttribute($key, $value)
    {
        parent::setAttribute(Str::snake($key), $value);
    }

}

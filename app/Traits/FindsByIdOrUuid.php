<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FindsByIdOrUuid
{
    /**
     * Scope to find a record by its integer ID or string UUID.
     *
     * @param  Builder  $query
     * @param  mixed  $id
     * @return Builder
     */
    public function scopeFindByIdOrUuid($query, $id)
    {
        if (is_numeric($id) || ctype_digit((string) $id)) {
            return $query->where($this->getTable().'.id', $id);
        }

        return $query->where($this->getTable().'.uuid', $id);
    }
}

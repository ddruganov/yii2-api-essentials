<?php

namespace ddruganov\Yii2ApiEssentials\traits;

trait Pagination
{
    /**
     * @return $this
     */
    public function page(int $value)
    {
        assert(is_int($this->limit), 'Set limit before setting page');
        return $this
            ->offset(($value - 1) * $this->limit);
    }

    /**
     * @return $this
     */
    public function getPageCount()
    {
        assert($this->limit !== 0, 'Limit cannot be 0 when getting page count');
        return ceil($this->count() / $this->limit);
    }
}

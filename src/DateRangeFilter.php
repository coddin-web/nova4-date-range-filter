<?php

declare(strict_types=1);

namespace Coddin\Filters;

use Laravel\Nova\Filters\Filter;

abstract class DateRangeFilter extends Filter
{
    public $component = 'date-range-filter';

    public function enableTime(): self
    {
        $this->withMeta(['enableTime' => true]);

        return $this;
    }

    public function dateFormat($format): self
    {
        $this->withMeta(['dateFormat' => $format]);

        return $this;
    }

    public function placeholder($placeholder): self
    {
        $this->withMeta(['placeholder' => $placeholder]);

        return $this;
    }
}

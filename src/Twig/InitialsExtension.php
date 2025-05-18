<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class InitialsExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [new TwigFilter('initials', $this->getInitials(...))];
    }

    public function getInitials(string $initials): string
    {
        $connectives = ['/ da /', '/ de /', '/ do /', '/ das /', '/ dos /', '/ e /', '/ d\'/'];
        $validNames = explode(' ', preg_replace($connectives, '', $initials));
        $initials = array_map(fn ($name) => substr(trim($name), 0, 1), $validNames);

        return implode('', $initials);
    }
}

<?php

namespace Test\CountNumberDays\Model\Resolver\Navigation;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;
class Identity implements IdentityInterface
{
    /** @var string */
    private $cacheTag = "my_module_count_number_days";

    /**
     * Get PromoBanners identities from resolved data
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        return [ $this->cacheTag ];
    }
}

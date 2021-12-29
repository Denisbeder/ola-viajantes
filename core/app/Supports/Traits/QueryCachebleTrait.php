<?php

namespace App\Supports\Traits;

use App\Supports\Services\QueryCachebleBuilderService;
use Rennokki\QueryCache\Traits\QueryCacheable;

trait QueryCachebleTrait
{
    use QueryCacheable;

    /**
     * {@inheritdoc}
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        $builder = new QueryCachebleBuilderService(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );

        if ($this->cacheFor) {
            $builder->cacheFor($this->cacheFor);
        } else {
            $builder->dontCache();
        }

        if ($this->cacheTags) {
            $builder->cacheTags($this->cacheTags);
        }

        if ($this->cachePrefix) {
            $builder->cachePrefix($this->cachePrefix);
        }

        if ($this->cacheDriver) {
            $builder->cacheDriver($this->cacheDriver);
        }

        if ($this->cacheUsePlainKey) {
            $builder->withPlainKey();
        }

        return $builder
            ->cacheBaseTags($this->getCacheBaseTags());
    }

}

<?php

namespace App\Supports\Traits;

trait PublishedScopeTrait
{
    /**
     * Scope a query to only include published records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query
            ->where('publish', 1)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('published_at', '<=', now())->orWhereNull('published_at');
                })
                ->where(function ($query) {
                    $query->where('unpublished_at', '>=', now())->orWhereNull('unpublished_at');
                });
            })
            ->where(function ($query) {
                if (method_exists($query->getModel(), 'category')) {
                    $query->doesntHave('category')
                        ->orWhereHas('category', function ($query) {
                            $query->where('publish', 1);
                        });
                }
            });
    }

    /**
     * Scope a query to include just published and records scheduled to leave.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query
            ->where('publish', 1)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->where('published_at', '>=', now())->orWhereNull('published_at');
                    })
                    ->where(function ($query) {
                        $query->where('unpublished_at', '>=', now())->orWhereNull('unpublished_at');
                    });
                })->orWhere(function ($query) {
                    $query->where(function ($query) {
                        $query->where('published_at', '<=', now())->orWhereNull('published_at');
                    })
                    ->where(function ($query) {
                        $query->where('unpublished_at', '>=', now())->orWhereNull('unpublished_at');
                    });
                });
            })
            ->where(function ($query) {
                if (method_exists($query->getModel(), 'category')) {
                    $query->doesntHave('category')
                        ->orWhereHas('category', function ($query) {
                            $query->where('publish', 1);
                        });
                }
            });
    }

    /**
     * Scope a COLLECTION to only include published with scheduleds records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeGetCollectPublished($query)
    {
        return $query->scheduled()
            ->latest('published_at')
            ->get()
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            });
    }
}
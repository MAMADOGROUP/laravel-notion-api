<?php

use FiveamCode\LaravelNotionApi\Endpoints\Block;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BlockRequest
{
    protected Collection $children;

    protected string $id;

    protected Block $apiRequest;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->apiRequest = \Notion::block($id);
        $this->children = new Collection();
    }

    /**
     * @return $this
     */
    public function load(): self
    {
        $this->loadChildren();

        return $this;
    }

    /**
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * Recursive load block children.
     *
     * @param string|null $cursor
     */
    protected function loadChildren(string $cursor = null): void
    {
        try {
            if ($cursor) {
                $this->apiRequest = $this->apiRequest->offset($cursor);
            }
            $pageBlocks = $this->apiRequest->children();
            $this->children = $this->children->concat(Arr::get($pageBlocks, 'results')->asCollection());

            if (Arr::get($pageBlocks, 'hasMore') && $cursor = Arr::get($pageBlocks, 'nextCursor')) {
                // Notion api allows 3 requests per second.
                usleep(350);
                $this->loadChildren($cursor);
            }
        } catch (Throwable $e) {
            info($e->getMessage());
        }
    }
}

<?php

use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;
use Illuminate\Support\Collection;

class NotionService
{
    /**
     * @param $pageId
     * @return Collection
     */
    public function loadPage($pageId): Collection
    {
        $page = new PageRequest($pageId);

        $pageBlocks = $page->load()->getChildren();
        $pageBlocks->transform(fn ($block) => $this->loadBlockChildren($block));

        return $pageBlocks;
    }

    /**
     * @param Block $block
     * @return Block
     */
    protected function loadBlockChildren(Block $block): Block
    {
        if ($block->hasChildren()) {
            $blockRequest = new BlockRequest($block->getId());

            usleep(350);
            $blockChildren = $blockRequest->load()->getChildren();

            $blockChildren->transform(fn ($block) => $this->loadBlockChildren($block));

            $block->appendChildren($blockChildren);
        }

        return $block;
    }
}
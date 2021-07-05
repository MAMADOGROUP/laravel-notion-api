<?php

namespace FiveamCode\LaravelNotionApi\Endpoints;

use FiveamCode\LaravelNotionApi\Entities\Collections\EntityCollection;
use FiveamCode\LaravelNotionApi\Notion;
use FiveamCode\LaravelNotionApi\Exceptions\NotionException;
use FiveamCode\LaravelNotionApi\Exceptions\HandlingException;
use FiveamCode\LaravelNotionApi\Entities\Collections\BlockCollection;
use Illuminate\Support\Arr;

/**
 * Class Block
 * @package FiveamCode\LaravelNotionApi\Endpoints
 */
class Block extends Endpoint
{
    /**
     * @var string
     */
    private string $blockId;

    /**
     * Block constructor.
     * @param Notion $notion
     * @param string $blockId
     * @throws HandlingException
     * @throws \FiveamCode\LaravelNotionApi\Exceptions\LaravelNotionAPIException
     */
    public function __construct(Notion $notion, string $blockId)
    {
        parent::__construct($notion);
        $this->blockId = $blockId;
    }

    /**
     * Retrieve block children
     * url: https://api.notion.com/{version}/blocks/{block_id}/children
     * notion-api-docs: https://developers.notion.com/reference/get-block-children
     *
     * @return array
     * @throws HandlingException
     * @throws NotionException
     */
    public function children(): array
    {
        $response = $this->get(
            $this->url(Endpoint::BLOCKS . '/' . $this->blockId . '/children' . "?{$this->buildPaginationQuery()}")
        );


        return [
            'hasMore' => Arr::get($this->response->json(), 'has_more'),
            'nextCursor' => Arr::get($this->response->json(), 'next_cursor'),
            'results' => new BlockCollection($response->json())
        ];
    }

    /**
     * @return array
     * @throws HandlingException
     */
    public function create(): array
    {
        throw new HandlingException('Not implemented');
    }
}

<?php

namespace FiveamCode\LaravelNotionApi\Entities\Blocks;

/**
 * Class Paragraph.
 */
class Paragraph extends TextBlock
{
    public static function create(array|string $textContent): Paragraph
    {
        $paragraph = new Paragraph();
        TextBlock::createTextBlock($paragraph, $textContent);

        return $paragraph;
    }

    public function __construct(array $responseData = null)
    {
        $this->type = 'paragraph';
        parent::__construct($responseData);
    }
}

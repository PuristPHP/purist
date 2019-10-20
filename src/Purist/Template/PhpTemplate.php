<?php

namespace Purist\Template;

use Psr\Http\Message\ResponseInterface;
use Purist\Http\Response\TextResponse;

final class PhpTemplate
{
    private $templateRoot;

    public function __construct(string $templateRoot)
    {
        $this->templateRoot = $templateRoot;
    }

    public function render(string $relativeFilePath, array $variables = []): ResponseInterface
    {
        $__filePath = sprintf(
            '%s/%s',
            rtrim($this->templateRoot, '/'), ltrim($relativeFilePath, '/')
        );

        if (!is_file($__filePath)) {
            throw new \Exception(
                sprintf('There is no template located at %s', $__filePath)
            );
        }

        ob_start();
        extract($variables, EXTR_OVERWRITE);
        include $__filePath;
        $contents = ob_get_clean();

        return new TextResponse($contents);
    }
}

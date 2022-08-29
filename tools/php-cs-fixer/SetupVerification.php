<?php


namespace Test;

use PhpCsFixer\Fixer\AbstractPhpUnitFixer;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;

class Test extends AbstractPhpUnitFixer
{

    protected function applyPhpUnitClassFix(Tokens $tokens, int $startIndex, int $endIndex): void
    {
      // TODO: Implement applyPhpUnitClassFix() method.
    }
  
    public function getDefinition(): FixerDefinitionInterface
    {
      // TODO: Implement getDefinition() method.
    }
}
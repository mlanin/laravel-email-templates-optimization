<?php

namespace Lanin\Laravel\EmailTemplatesOptimization;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Compiler extends BladeCompiler
{
    /**
     * @var array
     */
    private $cssFiles = [];

    /**
     * @var string|null
     */
    protected static $cssFilesContent = null;

    /**
     * EmailCompiler constructor.
     *
     * @param Filesystem $files
     * @param string $cachePath
     * @param array $cssFiles
     */
    public function __construct(Filesystem $files, $cachePath, array $cssFiles)
    {
        parent::__construct($files, $cachePath);

        $this->cssFiles = $cssFiles;
    }

    /**
     * Concat all css files.
     *
     * @param  array $files
     * @return string
     */
    protected function getCssFilesContent(array $files)
    {
        $css = '';
        foreach ($files as $file) {
            $css .= $this->files->get($file);
        }

        return $css;
    }

    /**
     * Compile the given Blade template contents.
     *
     * @param  string  $value
     * @return string
     */
    public function compileString($value)
    {
        if (is_null(static::$cssFilesContent)) {
            static::$cssFilesContent = $this->getCssFilesContent($this->cssFiles);
        }

        return parent::compileString($this->convertStyles($value));
    }

    /**
     * Convert css to inline styles.
     *
     * @param  string $value
     * @return string
     */
    protected function convertStyles($value)
    {
        $converter = new CssToInlineStyles();

        return urldecode($converter->convert($value, static::$cssFilesContent));
    }
}
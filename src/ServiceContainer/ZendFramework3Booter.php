<?php

namespace VirCom\Behat3ZendFramework3Extension\ServiceContainer;

class ZendFramework3Booter
{
    /**
     * @var string
     */
    protected $basePath;
    
    /**
     * @var string
     */
    protected $configurationFilePath;
    
    /**
     * @param string $basePath
     * @param string $configurationFilePath
     */
    public function __construct(
        string $basePath,
        string $configurationFilePath
    ) {
        $this->basePath = $basePath;
        $this->configurationFilePath = $configurationFilePath;
    }
    
    
    
}

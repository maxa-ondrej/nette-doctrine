<?php


namespace Expert\Maxa\Ondrej\Doctrine\Bridges\Nette;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Nette\DI\CompilerExtension;

/**
 * Class DoctrineExtension
 * Extension for nette framework
 * @package Expert\Maxa\Ondrej\Doctrine\Bridges\Nette
 */
class DoctrineExtension extends CompilerExtension
{
    /**
     * Config provided by default
     */
    private const DEFAULT_CONFIG = [
        'config' => [
            'devMode' => false,
            'proxyDir' => null,
            'cache' => null,
            'simpleAnnotationReader' => false
        ]
    ];

    /**
     * Loads config
     */
    public function loadConfiguration(): void
    {
        $config = array_merge_recursive(self::DEFAULT_CONFIG, $this->config);
        $connection = $config['connection'];
        $configuration = Setup::createAnnotationMetadataConfiguration(
            $config['config']['paths'],
            $config['config']['devMode'],
            $config['config']['proxyDir'],
            $config['config']['cache'],
            $config['config']['simpleAnnotationReader']
        );
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('entityManager'))
            ->setFactory([EntityManager::class, 'create'], [$connection, $configuration]);
    }
}
<?php

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use extas\components\plugins\PluginRepository;
use extas\components\plugins\Plugin;
use extas\components\plugins\repositories\PluginFieldSha1;
use extas\components\extensions\ExtensionRepository;
use extas\components\extensions\Extension;

/**
 * Class PluginUuidFieldTest
 *
 * @author jeyroik <jeyroik@gmail.com>
 */
class PluginFieldSha1Test extends TestCase
{
    /**
     * @var PluginRepository|null
     */
    protected ?PluginRepository $pluginRepo = null;

    /**
     * @var ExtensionRepository|null
     */
    protected ?ExtensionRepository $extRepo = null;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->pluginRepo = new PluginRepository;
        $this->extRepo = new ExtensionRepository();
    }

    public function tearDown(): void
    {
        $this->pluginRepo->delete([Plugin::FIELD__CLASS => PluginUuidField::class]);
        $this->extRepo->delete([Extension::FIELD__CLASS => 'NotExistingClass']);
    }

    public function testSha1()
    {
        $this->installUuidPlugin();

        /**
         * @var $extension Extension
         */
        $extension = $this->extRepo->create(new Extension([
            Extension::FIELD__CLASS => 'NotExistingClass',
            Extension::FIELD__SUBJECT => '@sha1(test)',
            Extension::FIELD__METHODS => [
                '@sha1(test)'
            ]
        ]));

        $this->assertEquals(sha1('test'), $extension->getSubject());
        $this->assertEquals([sha1('test')], $extension->getMethods());
    }

    protected function installUuidPlugin()
    {
        $this->pluginRepo->create(new Plugin([
            Plugin::FIELD__CLASS => PluginFieldSha1::class,
            Plugin::FIELD__STAGE => 'extas.extensions.create.before'
        ]));
    }
}

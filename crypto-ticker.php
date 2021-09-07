<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;


/**
 * Class CryptoTickerPlugin
 * @package Grav\Plugin
 */
class CryptoTickerPlugin extends Plugin
{
    /**
     * Composer autoload
     *
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onGetPageTemplates' => ['onGetPageTemplates', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0]
        ];
    }

    
    /**
     * Add page template types.
     *
     * @return void
     */
    public function onGetPageTemplates(Event $event)
    {
        /** @var Types $types */
        $types = $event->types;
        $types->scanTemplates('plugins://crypto-ticker/templates');
    }

    /**
     * Add current directory to twig lookup paths.
     *
     * @return void
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    
    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main events we are interested in
        $this->enable([
            'onPagesInitialized' => ['onPagesInitialized', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);
    }
    
    public function onPagesInitialized() { }
    
    public function onTwigSiteVariables() {
        
        if ($this->config->get('plugins.crypto-ticker.built_in_css')) {
            $this->grav['assets']->add('plugin://crypto-ticker/css/crypto-ticker.css');
        }

        $coins = $this->paprika();
        
        // Adding variables to the templates
        $this->grav['twig']->twig_vars['seo_title'] = $this->config->get('plugins.crypto-ticker.seo_title');
        $this->grav['twig']->twig_vars['coins'] = $coins;
    }

    private function paprika(){
        $this->autoload();
        $client = new \Coinpaprika\Client();

        $coinIds = $this->config->get('plugins.crypto-ticker.coins');
        
        $coins = array_map( function ($coinId) use ($client) {
            $coin = $client->getTickerByCoinId($coinId);

            return [
                "name" => $coin->getName(),
                "symbol" => $coin->getSymbol(),
                "usd" => number_format($coin->getPriceUSD(), 2),
                // "btc" => $coin->getPriceBTC(),
                "change" => $coin->getPercentChange24h()
            ];
        }, $coinIds);

        return $coins;
        
    }
}

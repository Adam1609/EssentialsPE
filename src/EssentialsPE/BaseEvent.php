<?php
namespace EssentialsPE;

use pocketmine\event\plugin\PluginEvent;

abstract class BaseEvent extends PluginEvent{
    /**
     * @param Loader $plugin
     */
    public function __construct(Loader $plugin){
        parent::__construct($plugin);
    }
}

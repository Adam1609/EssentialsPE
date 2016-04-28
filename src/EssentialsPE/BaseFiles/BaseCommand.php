<?php
namespace EssentialsPE\BaseFiles;

use EssentialsPE\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;

abstract class BaseCommand extends Command implements PluginIdentifiableCommand{
    /** @var BaseAPI  */
    private $api;
    /** @var bool|string */
    private $consoleUsageMessage;

    /**
     * @param BaseAPI $api
     * @param string $name
     * @param string $description
     * @param null|string $usageMessage
     * @param bool|null|string $consoleUsageMessage
     * @param array $aliases
     */
    public function __construct(BaseAPI $api, $name, $description = "", $usageMessage = null, $consoleUsageMessage = true, array $aliases = []){
        #$identifier = "commands.essentialspe";
        /** @var array $identifier */
        #$identifier = $this->getAPI()->getMessage($identifier);
        #parent::__construct($identifier["name"], $identifier["description"], $usageMessage, $aliases); TODO
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->api = $api;
        $this->consoleUsageMessage = $consoleUsageMessage;
        $this->setPermissionMessage($this->getAPI()->getMessage("error.permission"));
    }

    /**
     * @return Loader
     */
    public final function getPlugin(): Loader{
        return $this->getAPI()->getEssentialsPEPlugin();
    }

    /**
     * @return BaseAPI
     */
    public final function getAPI(): BaseAPI{
        return $this->api;
    }

    /**
     * @return string
     */
    public function getUsage(): string{
        return "/" . parent::getName() . " " . parent::getUsage();
    }

    /**
     * @return bool|null|string
     */
    public function getConsoleUsage(){
        return $this->consoleUsageMessage;
    }

    /**
     * Function to give different type of usages, switching from "Console" and "Player" executors of a command.
     * This function can be overridden to fit any command needs...
     *
     * @param CommandSender $sender
     * @param string $alias
     */
    public function sendUsage(CommandSender $sender, string $alias){
        $error = "error.usage";
        $message = "/$alias ";
        if(!$sender instanceof Player){
            if(is_string($this->consoleUsageMessage)){
                $message .= $this->consoleUsageMessage;
            }elseif(!$this->consoleUsageMessage){
                $error = "error.ingame";
            }else{
                $message .= str_replace("[player]", "<player>", parent::getUsage());
            }
        }else{
            $message = parent::getUsage();
        }
        $this->sendMessage($sender, $error, $message);
    }

    /**
     * @param CommandSender $sender
     * @param string $message
     * @param ...$args
     */
    public function sendMessage(CommandSender $sender, $message, ...$args){
        $sender->sendMessage($this->getAPI()->getMessage($message, ...$args));
    }
}

<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Vanish extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "vanish", "Hide from other players!", "[player]", true, ["v"]);
        $this->setPermission("essentials.vanish.use");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, $alias, array $args): bool{
        if(!$this->testPermission($sender)){
            return false;
        }
        if((!isset($args[0]) && !$sender instanceof Player) || count($args) > 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        $player = $sender;
        if(isset($args[0])){
            if(!$sender->hasPermission("essentials.vanish.other")){
                $sender->sendMessage($this->getPermissionMessage());
                return false;
            }elseif(!($player = $this->getAPI()->getPlayer($args[0]))){
                $this->sendMessage($sender, "essentials.error.player-not-found", $args[0]);
                return false;
            }
        }
        $this->getAPI()->switchVanish($player);
        $this->sendMessage($player, "commands.vanish.vanish-" . $v = ($this->getAPI()->isVanished($player) ? "enabled" : "disabled"));
        if($player !== $sender){
            $this->sendMessage($sender, "command.vanish.other-" . $v);
        }
        return true;
    }
}

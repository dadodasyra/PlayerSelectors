<?php

declare(strict_types=1);

namespace Ad5001\PlayerSelectors\selector;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class ClosestPlayer extends Selector{
    
    public function __construct(){
        parent::__construct("Closest player", "p", false);
    }

    /**
     * Executes the selector. 
     * Documentation is in the Selector.php file.
     *
     * @param CommandSender $sender
     * @param array $parameters
     * @return array
     */
    public function applySelector(CommandSender $sender, array $parameters = []): array{
        $online = Server::getInstance()->getOnlinePlayers();
        // Console
        if(!($sender instanceof Player)) {
            if(count($online) > 0){
                return [$online[array_keys($online)[0]]->getName()];
            } else {
                return [$sender->getName()];
            }
        }
        // Player
        if(count($online) > 1){
			$selectedP = null;
            // Checking the closest player
            foreach($online as $p){
                if($p->getWorld()->getDisplayName() == $sender->getWorld()->getDisplayName() &&
                 (!isset($selectedP) || $p->getPosition()->distanceSquared($sender->getPosition()) < $selectedP->getPosition()->distanceSquared($sender->getPosition()))){
                    $selectedP = $p;
                }
            }
            return [$selectedP->getName()];
        } else {
            // Otherwise, just return sender's name because there's no other player.
            return [$sender->getName()];
        }
    }
}

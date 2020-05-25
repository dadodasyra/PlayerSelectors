<?php
declare(strict_types=1);


namespace Ad5001\PlayerSelectors\selector;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;


class RandomPlayer extends Selector{
    
    public function __construct(){
        parent::__construct("Random player", "r", true);
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
        $defaultParams = Selector::DEFAULT_PARAMS;
        if($sender instanceof Player){
            $defaultParams["x"] = $sender->getPosition()->getX();
            $defaultParams["y"] = $sender->getPosition()->getY();
            $defaultParams["z"] = $sender->getPosition()->getZ();
        }
        $params = $parameters + $defaultParams;
        $possible = [];
        foreach(Server::getInstance()->getOnlinePlayers() as $p){
            if($p->getWorld()->getDisplayName() !== $params["lvl"] && $params["lvl"] !== "") continue; // Not in the right level
            if(!$this->checkDefaultParams($p, $params)) continue;
            $possible[] = $p;
        }
        if(count($possible) == 0) return [];
        return [$possible[array_rand($possible)]->getName()];
    }
}
<?php
declare(strict_types=1);

namespace NgLam2911\SimpleCobblestoneGenerator;

use pocketmine\block\Opaque;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class CobblestoneGeneratorBlock extends Opaque{

	public function getLightLevel() : int{
		return 10;
	}

	public function onScheduledUpdate() : void{
		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if ($tile instanceof CobblestoneGeneratorTile){
			if ($tile->onUpdate()){
				$this->getPosition()->getWorld()->scheduleDelayedBlockUpdate($this->getPosition(), CobblestoneGeneratorTile::DELAY_TIME);
			}
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
		if ($player == null){
			return parent::onInteract($item, $face, $clickVector, $player);
		}
		if ($tile instanceof CobblestoneGeneratorTile){
			foreach($tile->getInventory()->getContents() as $item){
				if ($player->getInventory()->canAddItem($item)){
					$player->getInventory()->addItem($item);
					$tile->getInventory()->removeItem($item);
				} else {
					break;
				}
			}
		}
		return parent::onInteract($item, $face, $clickVector, $player);
	}
}
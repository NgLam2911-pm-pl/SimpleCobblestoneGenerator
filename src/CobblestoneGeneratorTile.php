<?php
declare(strict_types=1);

namespace NgLam2911\SimpleCobblestoneGenerator;

use pocketmine\block\tile\Container;
use pocketmine\block\tile\ContainerTrait;
use pocketmine\block\tile\Nameable;
use pocketmine\block\tile\NameableTrait;
use pocketmine\block\tile\Spawnable;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\SimpleInventory;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Server;
use pocketmine\world\World;

class CobblestoneGeneratorTile extends Spawnable implements Nameable, Container{
	use NameableTrait;
	use ContainerTrait;

	public const DELAY_TIME = 10; //0.5s
	public const INVENTORY_SIZE = 50; //3200 Items

	protected Inventory $inventory;

	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->inventory = new SimpleInventory(self::INVENTORY_SIZE);
	}

	public function getDefaultName() : string{
		return "Cobblestone Generator";
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		//TODO: Add Additional Spawn Data
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->getBlock()->getPosition()->getWorld()->scheduleDelayedBlockUpdate($this->getBlock()->getPosition(), self::DELAY_TIME);
		$this->loadName($nbt);
		$this->loadItems($nbt);
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$this->saveName($nbt);
		$this->saveItems($nbt);
	}

	public function getRealInventory() : Inventory{
		return $this->getInventory();
	}

	public function getInventory() : Inventory{
		return $this->inventory;
	}

	public function onUpdate() : bool{
		$this->timings->startTiming();
		if ($this->isClosed()){
			return false;
		}
		if ($this->getInventory()->canAddItem(VanillaBlocks::COBBLESTONE()->asItem())){
			$this->getInventory()->addItem(VanillaBlocks::COBBLESTONE()->asItem());
		}
		$this->timings->stopTiming();
		return true;
	}
}
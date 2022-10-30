<?php
declare(strict_types=1);

namespace NgLam2911\SimpleCobblestoneGenerator;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\block\tile\TileFactory;
use pocketmine\item\ToolTier;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase{

	protected function onLoad() : void{
		TileFactory::getInstance()->register(CobblestoneGeneratorTile::class,  ["cobblestone_generator"]);
		BlockFactory::getInstance()->register(new CobblestoneGeneratorBlock(new BlockIdentifier(BlockLegacyIds::STONECUTTER, 0, null, CobblestoneGeneratorTile::class), "Cobblestone Generator", new BlockBreakInfo(3.5, BlockToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel())), true);
	}
}
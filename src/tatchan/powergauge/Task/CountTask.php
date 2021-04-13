<?php


namespace tatchan\powergauge\Task;



use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class CountTask extends Task
{
    /**@var Player */
    private $player;

    /** @var float  */
    private $count = 0;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $player = $this->player;
        $this->count += 0.5;
        $gauge = "";
        for($i = 0; $i < /*ゲージの文字数/2*/40; $i++){
            $gauge .= ($this->count > $i ? TextFormat::RED : TextFormat::GRAY) . "|";
        }
        $player->sendTip(number_format($this->count, 1) . " " . $gauge);
    }
    public function getCount() :float{
        return $this->count;
    }

}
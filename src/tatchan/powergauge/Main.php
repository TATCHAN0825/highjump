<?php

declare(strict_types=1);

namespace tatchan\powergauge;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\TaskHandler;
use pocketmine\utils\TextFormat;
use tatchan\powergauge\Task\CountTask;
use pocketmine\math\Vector3;


class Main extends PluginBase implements Listener{

    /** @var TaskHandler[] */
    private $taskhandlers = []

    /** @var int[] */
    private $lastJump = [];

	public function onEnable() : void{
	    $this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	}
	public function onSneek(PlayerToggleSneakEvent $event){
	    $player = $event->getPlayer();
	    $name = $player->getName();
	    if($event->isSneaking()){
            if(!isset($this->taskhandlers[$name])) {
                $this->taskhandlers[$name] = $this->getScheduler()->scheduleRepeatingTask(new CountTask($player), 2);
            }
        }else{
	        if(isset($this->taskhandlers[$name])){
	            /** @var  CountTask $task */
	            $task = $this->taskhandlers[$name]->getTask();
	            $count = $task->getCount();
	            $player->sendTip(TextFormat::BOLD . TextFormat::YELLOW . "JUMP!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
	            $player->setMotion(new Vector3(0, $count / 10, 0));

	            $this->lastJump[$name] = time();

                $this->taskhandlers[$name]->cancel();
	            unset($this->taskhandlers[$name]);
            }
        }
    }

    public function onDamage(EntityDamageEvent $event){
	    if($event->getCause() == EntityDamageEvent::CAUSE_FALL){
	        $entity = $event->getEntity();
	        if($entity instanceof Player){
	            $name = $entity->getName();
                if(isset($this->lastJump[$name])){
                    if(time() == $this->lastJump <= $this->){
                        //
                    }

                    unset($this->lastJump[$name]);
                }
            }
        }
    }


	public function onDisable() : void{

	}
}

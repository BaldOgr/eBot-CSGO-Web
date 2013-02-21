<?php

/**
 * Players
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    PhpProject1
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Players extends BasePlayers {

	public function getRatioHs() {
		return ($this->getHs() > 1) ? round(($this->getHs() / $this->getNbKill()) * 100, 2) : 0;
	}

	public function getRatio() {
		return ($this->getDeath() > 1) ? round(($this->getNbKill() / $this->getDeath()), 2) : $this->getNbKill();
	}

	public function getWeaponsStats() {
		$weapons = array();
		$query = "SELECT `weapon`, count(*) as nb FROM player_kill WHERE headshot = 0 AND killer_id = '".$this->getId()."' GROUP BY `weapon`";
		$rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($query);
		foreach ($rs as $v) {
			$weapons[$v["weapon"]]["normal"] = $v["nb"];
		}

		$query = "SELECT `weapon`, count(*) as nb FROM player_kill WHERE headshot = 1 AND killer_id = '".$this->getId()."' GROUP BY `weapon`";
		$rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($query);
		foreach ($rs as $v) {
			$weapons[$v["weapon"]]["hs"] = $v["nb"];
		}

		return $weapons;
	}

}
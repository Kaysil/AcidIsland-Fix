<?php
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class HelpSubCommand extends SubCommand
{
    public function canUse(CommandSender $sender) {
        return $sender->hasPermission("myplot.command.help");
    }

    /**
     * @return \MyPlot\Commands
     */
    private function getCommandHandler()
    {
        return $this->getPlugin()->getCommand($this->translateString("command.name"));
    }

    public function execute(CommandSender $sender, array $args) {
        if (count($args) === 0) {
            $pageNumber = 1;
        } elseif (is_numeric($args[0])) {
            $pageNumber = (int) array_shift($args);
            if ($pageNumber <= 0) {
                $pageNumber = 1;
            }
        } else {
            return false;
        }

        if ($sender instanceof ConsoleCommandSender) {
            $pageHeight = PHP_INT_MAX;
        } else {
            $pageHeight = 5;
        }

        $commands = [];
        foreach ($this->getCommandHandler()->getCommands() as $command) {
            if ($command->canUse($sender)) {
                $commands[$command->getName()] = $command;
            }
        }
        ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);
        $commands = array_chunk($commands, $pageHeight);
        /** @var SubCommand[][] $commands */

							//////
            $sender->sendMessage("§c-=- §a§lAcidIsland - Command §r§c-=-");
			$sender->sendMessage("§l§a/is auto§7 - §fĐi đến một hòn đảo");
			$sender->sendMessage("§l§a/is claim§7 - §fNhận ngay hòn đảo bạn đang đứng");
			$sender->sendMessage("§l§a/is addhelper §e<player>§7 - §fThêm người vào đảo của bạn");
			$sender->sendMessage("§l§a/is removehelper §e<player>§7 - §fXóa người chơi trong đảo của bạn");
			$sender->sendMessage("§l§a/is homes§7 - §fDanh sách đảo của bạn");
			$sender->sendMessage("§l§a/is home §e<Số> §7 - §fDịch chuyển về đảo của bạn");
			$sender->sendMessage("§l§a/is info§7 - §fXem thông tin hòn đảo");
			$sender->sendMessage("§l§a/is give §e<Tên người chơi> §7 - §fCho người khác hòn đảo của bạn");
			$sender->sendMessage("§l§a/is warp §e<X;Y> §7 - §fDi chuyển đến hòn đảo nào đó");
			$sender->sendMessage("§c------------------------------------------");
        return true;
    }
}

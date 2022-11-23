<?php

namespace App\Command;


use Psr\Cache\CacheItemInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Cache\CacheInterface;

#[AsCommand(
    name: 'app:system:checker',
    description: 'System checker',
)]
class SystemCheckerCommand extends Command
{
    private const NAME = 'app:system:checker';
    
    public function __construct(private readonly CacheInterface $cacheItem)
    {
        parent::__construct(self::NAME);
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        var_export(
            $this->cacheItem->get(
                'itemKey',
                function () {
                    return 'itemValue';
                }
            )
        );
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        
        return Command::SUCCESS;
    }
}

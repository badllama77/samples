<?php
namespace Test\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Test\Roman;
use Test\Map\IntegerRomanMap;

/**
 * Ackermann implementation
 * @author Eric Myers <emyers@millisoftware.com>
 */
class RomanCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:roman')
            ->setDescription('Interprets an integer between 1 and 3999 to a roman numeral')
            ->addArgument(
                'integer',
                InputArgument::REQUIRED,
                'Number between 1 and 3999'
            )
            ->addOption(
                'mapping',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Enter custom mapping (--mapping="10,X 50,L 100,C 500,D 1000,M") 1 and 5 are not allowed'
            )->setHelp(
<<<EOF
The <info>%command.name%</info> command interprets an integer between 1 and 3999 to a roman numeral. 
You cannot map new roman numeral s for 1 or 5.  Decimals are interpreted as well and represented as lower case
numbers for ease of understanding:
  
  <info>php %command.full_name% 42</info>
  <info>php %command.full_name% --mapping="10,Y 100,T  50,O" 450</info>

EOF
            );

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $map = new IntegerRomanMap();
        if ($input->getOption('mapping')) {
            $customMap = array();
            $mapping = explode(' ', $input->getOption('mapping'));
            foreach ($mapping as $value) {
                $item = explode(',', $value);
                if (!empty($item[0]) && !empty($item[1])) {
                    $customMap[$item[0]] = $item[1];
                }
            }
            $map->useCustomMap($customMap);
        }


        $integer = $input->getArgument('integer');
        if (strpos($integer, '.') !== false) {
            $roman = new Roman\RomanFloat($integer, $map);
        } else {
            $roman = new Roman\Roman($integer, $map);
        }

        $output->writeln((string)$roman);
    }
}

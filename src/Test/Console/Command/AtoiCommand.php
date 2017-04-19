<?php
namespace Test\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interprets string as integer 
 * @author Eric Myers <emyers@millisoftware.com>
 */
class AtoiCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:atoi')
            ->setDescription("Interprets a string as integer")
            ->addArgument(
                'string',
                InputArgument::REQUIRED,
                'String containing an integer'
            )->setHelp(
<<<EOF
The <info>%command.name%</info> command interprets a string as integer. Ignores leading whitespaces. 
Starting from first character takes a series of digits starting with an optional + or -.
  
  <info>php %command.full_name% 21342a</info>
  <info>php %command.full_name% -- -45542asfa</info>
  <info>php %command.full_name% "90452 hello"</info>
  <info>php %command.full_name% "21342 there you are"</info>
EOF
            );

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = $input->getArgument('string');

        $output->writeln($this->atoi($string));
    }

    /**
     * Interpret an integer in a string
     * 
     * @param  string $str 
     * @return integer
     */
    protected function atoi($str)
    {
        $i=0;
        $res = 0;
        $negative = false;
        $str = ltrim($str, " +");
        $negative = preg_match('/^[-]/', $str) && ++$i;

        for (; $i <strlen($str); ++$i) {
            if (!is_numeric($str[$i])) {
                break;
            }

            $res=($res<<3) + ($res<<1) + $str[$i];
        }

        if ($negative) {
            $res = -$res;
        }

        return $res;
    }
}

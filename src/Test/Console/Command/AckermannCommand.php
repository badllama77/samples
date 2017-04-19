<?php
namespace Test\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Ackermann implementation
 * @author Eric Myers <emyers@millisoftware.com>
 */
class AckermannCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:ackermann')
            ->setDescription('Non recursive ackermann function')
            ->addArgument(
                'm',
                InputArgument::REQUIRED,
                'Number'
            )
            ->addArgument(
                'n',
                InputArgument::REQUIRED,
                'Number'
            )->setHelp(
<<<EOF
  <info>php %command.full_name% 2 4</info>
  <info>php %command.full_name% 3 1</info>
  <info>php %command.full_name% 4 1</info>
EOF
            );
    }

    /**
     * {inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->ackermann($input->getArgument('m'), $input->getArgument('n'));

        $output->writeln("Result: $result");
    }

    /**
     * Non-recursive Ackermann function  
     * @param  integer $m
     * @param  integer $n
     * @return integer
     */
    private function ackermann($x, $y)
    {
        if ( $x==0 ) {
            return $y + 1;
        }
        elseif ( $y==0 ) {
            return ackermann( $x-1 , 1 );
        }

        return ackermann( $x-1, ackermann( $x , $y-1 ) );

    }
}

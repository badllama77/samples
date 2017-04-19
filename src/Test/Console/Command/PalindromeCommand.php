<?php
namespace Test\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Determines if a string is a palindrome
 * @author Eric Myers <emyers@millisoftware.com>
 */
class PalindromeCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('test:palindrome')
            ->setDescription('Determines if the string is a palindrome.')
            ->addArgument(
                'string',
                InputArgument::REQUIRED,
                'String to determine if it is a palindrome'
            )->setHelp(
<<<EOF
The <info>%command.name%</info> command determines if a string is a palindrome.
  
  <info>php %command.full_name% kayak</info>
  <info>php %command.full_name%  "I prefer PI"</info>
  <info>php %command.full_name% "I, man, am regal; a German am I." </info>
  <info>php %command.full_name% aibohphobia</info>

EOF
            );

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = $input->getArgument('string');

        if ($this->isPalindrome($string)) {
            $output->writeln(sprintf("Yes %s is a palindrome", $string));
        } else {
            $output->writeln(sprintf("No %s is not a emordnilap...err I mean palindrome", $string));
        }
        

    }

    public function isPalindrome($val)
    {
        $val = preg_replace('/[^A-Za-z0-9]/', '', strtolower($val));
        for ($i=1; $i<(strlen($val)/2); $i++) {
            if ($val[$i - 1] != $val[strlen($val) - $i]) {
                return false;
            }
        }
        return true;
    }
}

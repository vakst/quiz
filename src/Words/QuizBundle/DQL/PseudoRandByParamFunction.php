<?php
namespace Words\QuizBundle\DQL;
 
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
 
class PseudoRandByParamFunction extends FunctionNode
{
    protected $argument1;
    protected $argument2;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); 
        $parser->match(Lexer::T_OPEN_PARENTHESIS); 
        $this->argument1 = $parser->StringPrimary(); 
        $parser->match(Lexer::T_COMMA); 
        $this->argument2 = $parser->StringExpression(); 
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); 
    }
 
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'pseudoRandByParam(' . $this->argument1->dispatch($sqlWalker) . ','.$this->argument2->dispatch($sqlWalker).')';
    }
}
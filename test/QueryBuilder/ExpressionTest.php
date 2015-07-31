<?php

namespace Modules\DBAL\QueryBuilder;

use Miny\Log\NullLog;

class ExpressionTest extends \PHPUnit_Framework_TestCase
{

    public function testSimpleExpression()
    {
        $expr = new Expression();
        $expr->eq('a', 'b')
             ->andX(
                 $expr->lt('c', 'd')
             )->orX(
                $expr->in('e', ['f', 'g'])
            );

        $this->assertEquals('((a=b AND c<d) OR e IN(f, g))', $expr->get());
    }

    public function testEq()
    {
        $expr = new Expression();
        $expr->eq('a', 'b')
             ->andX(
                 $expr->eq('c', ['d', 'e']),
                 $expr->neq('f', 'g'),
                 $expr->neq('h', ['i', 'j'])
             );

        $this->assertEquals('(a=b AND c IN(d, e) AND f<>g AND h NOT IN(i, j))', $expr->get());
    }

    public function testNestedConditions()
    {
        $expr = new Expression();
        $this->assertEquals(
            '(a=b AND (c=d OR e=f))',
            $expr->eq('a', 'b')
                 ->andX(
                     $expr->eq('c', 'd')
                          ->orX(
                              $expr->eq('e', 'f')
                          )
                 )->get()
        );
    }

    public function testInWithSelect()
    {
        $platform = $this->getMockForAbstractClass('\\Modules\\DBAL\\Platform');
        $driver   = $this->getMockForAbstractClass('\\Modules\\DBAL\\Driver', [$platform, new NullLog()]);

        $select = new Select($driver);
        $select->select('*');
        $select->from('table');

        $expr = new Expression();

        $this->assertEquals(
            'c IN(SELECT * FROM table)',
            $expr->in('c', $select)->get()
        );
    }
}

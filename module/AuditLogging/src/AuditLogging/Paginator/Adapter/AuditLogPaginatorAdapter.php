<?php
namespace AuditLogging\Paginator\Adapter;

use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSetInterface;

class AuditLogPaginatorAdapter extends DbSelect
{
//     /**
//      * The SQL statement contains JOINs,
//      * so that every result entity actually needs multiple rows to be built --
//      * or in other words, every entity takes multiple rows.
//      * That means an "entity oriented" (and not "row oriented") solution was needed.
//      * To acieve this, the method replaces the LIMIT by an IN restriction of the overriden method.
//      *
//      * {@inheritDoc}
//      * @see DbSelect::getItems()
//      */
//     public function getItems($offset, $itemCountPerPage)
//     {
//         $select = clone $this->select;
//         // $select->offset($offset);
//         // $select->limit($itemCountPerPage);
//         $relevantIds = $this->getRelevantIds($offset, $itemCountPerPage);
//         $resultArray = [];
//         if ($relevantIds) {
//             $select->where->in('audit_log.id', $relevantIds);
//             if ($this->userId) {
//                 $select->where(['user_id = ?' => $this->userId]);
//             }
            
//             $statement = $this->sql->prepareStatementForSqlObject($select);
//             $result    = $statement->execute();
            
//             $resultSet = clone $this->resultSetPrototype;
//             $resultSet->initialize($result);

//             $resultArray = iterator_to_array($resultSet);
//         }

//         return $resultArray;
//     }

    /**
     * 
     * {@inheritDoc}
     * @see \Zend\Paginator\Adapter\DbSelect::count()
     */
    public function count()
    {
        $select = new Select();
        $select->from('audit_log')->columns([self::ROW_COUNT_COLUMN_NAME => new Expression('COUNT(*)')]);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
        $row       = $result->current();
        $this->rowCount = $row[self::ROW_COUNT_COLUMN_NAME];

        return $this->rowCount;
    }

//     /**
//      * Returns the IDs for the retrieving of objects.
//      *
//      * @param unknown $offset
//      * @param unknown $itemCountPerPage
//      */
//     protected function getRelevantIds($offset, $itemCountPerPage)
//     {
//         $sql = new Sql($this->sql->getAdapter());
//         $select = $sql->select('audit_log');
//         $select->columns(['id']);
//         $select->offset($offset);
//         $select->limit($itemCountPerPage);
//         if ($this->userId) {
//             $select->where(['user_id = ?' => $this->userId]);
//         }

//         $statement = $this->sql->prepareStatementForSqlObject($select);
//         $result    = $statement->execute();

//         $resultArray = iterator_to_array($result);
//         $relevantIds = array_column($resultArray, 'id');

//         return $relevantIds;
//     }

}

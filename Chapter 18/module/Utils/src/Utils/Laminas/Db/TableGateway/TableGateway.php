<?php

namespace Utils\Laminas\Db\TableGateway;

use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Update;
use Laminas\Db\Sql\Delete;

class TableGateway extends \Laminas\Db\TableGateway\TableGateway
{
    protected $platform;

    public function __construct(
        $table,
        \Laminas\Db\Adapter\AdapterInterface $adapter,
        $features = null,
        \Laminas\Db\ResultSet\ResultSetInterface $resultSetPrototype = null,
        \Laminas\Db\Sql\Sql $sql = null
    ) {
        parent::__construct($table, $adapter, $features, $resultSetPrototype, $sql);
        $this->platform = new \Laminas\Db\Adapter\Platform\Mysql($this->adapter->driver);
    }

    public function selectWith(Select $select)
    {
        \Utils\Logs\Debug::dump($select->getSqlString($this->platform));
        return parent::selectWith($select);
    }

    protected function executeInsert(Insert $insert)
    {
        \Utils\Logs\Debug::dump($insert->getSqlString($this->platform), ['log' => true]);
        return parent::executeInsert($insert);
    }

    protected function executeUpdate(Update $update)
    {
        \Utils\Logs\Debug::dump($update->getSqlString($this->platform), ['log' => true]);
        return parent::executeUpdate($update);
    }

    protected function executeDelete(Delete $delete)
    {
        \Utils\Logs\Debug::dump($delete->getSqlString($this->platform), ['log' => true]);
        return parent::executeDelete($delete);
    }
}


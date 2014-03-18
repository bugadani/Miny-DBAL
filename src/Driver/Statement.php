<?php

/**
 * This file is part of the Miny framework.
 * (c) Dániel Buga <daniel@bugadani.hu>
 *
 * For licensing information see the LICENSE file.
 */

namespace Modules\DBAL\Driver;

use PDO;

interface Statement
{
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverdata = null);

    public function bindParam(
        $parameter,
        &$variable,
        $dataType = PDO::PARAM_STR,
        $length = null,
        $driverOptions = null
    );

    public function bindValue($parameter, $value, $dataType = PDO::PARAM_STR);

    public function closeCursor();

    public function columnCount();

    public function errorCode();

    public function errorInfo();

    public function execute($inputParameters);

    public function fetch(
        $fetchStyle = null,
        $cursorOrientation = PDO::FETCH_ORI_NEXT,
        $cursorOffset = 0
    );

    public function fetchAll(
        $fetchStyle = null,
        $fetchArgument = null,
        array $ctorArgs = array()
    );

    public function fetchColumn($columnNumber = 0);

    public function getAttribute($attribute);

    public function getColumnMeta($column);

    public function nextRowset();

    public function rowCount();

    public function setAttribute($attribute, $value);

    public function setFetchMode($mode);
}

<?php

namespace Zaks\MySQLOptimier;

class OptimizeResult
{
    /**
     * Table name
     *
     * @var string
     */
    public string $msgText;

    /**
     * Table name
     *
     * @var string
     */
    public string $msgType;

    /**
     * Table name
     *
     * @var string
     */
    public string $operation;

    /**
     * Table name
     *
     * @var string
     */
    public string $table;

    /**
     * Construction
     *
     * @param string $table
     * @param string $operation
     * @param string $msgType
     * @param string $msgText
     */
    public function __construct(string $table, string $operation, string $msgType, string $msgText)
    {
        $this->msgText   = $msgText;
        $this->msgType   = $msgType;
        $this->operation = $operation;
        $this->table     = $table;
    }

    /**
     * Create a new instance with ease from outside method
     *
     * @param object $result
     * @return static
     */
    public static function fromSelectResult(object $result)
    {
        return new static($result->Table, $result->Op, $result->Msg_type, $result->Msg_text);
    }
}

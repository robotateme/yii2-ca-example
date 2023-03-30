<?php

namespace domain\scenarios\admin\getList;

/**
 * Class GetListAdminRequest
 * @package domain\scenarios\admin\getList
 */
class GetListAdminRequest
{
    /** @var int|null */
    public ?int $limit = null;

    /** @var int|null */
    public ?int $offset = null;
}
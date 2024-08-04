<?php

class PageModel extends DatabaseModel
{
    // TODO: es necesario esto cuando no se agrega nada al construct¿??
    public function __construct()
    {
        parent::__construct();
    }

    public function getPages(): array
    {
        $query = "SELECT * FROM pages";
        return $this->selectAll($query);
    }
}
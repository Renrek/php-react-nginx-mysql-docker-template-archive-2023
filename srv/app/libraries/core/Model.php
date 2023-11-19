<?php declare(strict_types=1);

namespace App\Libraries\Core;

use App\Config\DatabaseConst;
use App\Libraries\Data\DB;
use AllowDynamicProperties;
use App\Libraries\Injection\ContainerTrait;

// At the end of the day this may be better using a build step to get away from Dynamic Properties.
#[AllowDynamicProperties]
class Model {
    
    use ContainerTrait;
    
    protected DB $db;
    protected string $table;
    protected string $primaryKey;
    protected string $schema = DatabaseConst::NAME;
    protected array $publicFields;
    
    public function new() : void {
        foreach ($this->publicFields as $fieldName) {
            $this->$fieldName = NULL;
        }
    }
    
    public function save() : void {
        $primaryKey = $this->primaryKey;
        if($this->$primaryKey !== NULL){
            $statement = 'UPDATE '.$this->table.' SET '.$this->updateFields().' WHERE '.$this->primaryKey.' = '.$this->$primaryKey;
            $this->db->run($statement, $this->saveValues());
        }else{
            $fields = $this->insertFields();
            $statement = 'INSERT INTO '.$this->table.' ( '.$fields->labels.' ) VALUES ( '.$fields->markers.' )';
            $this->db->run($statement, $this->saveValues());
        }
    }

    public function remove() : void { // May want to convert this to soft delete.
        $primaryKey = $this->primaryKey;
        $statement = 'DELETE FROM '.$this->table.' WHERE '.$this->primaryKey.' = ?';
        $this->db->run($statement, [$this->$primaryKey]);
    }

    public function getByPrimaryKey(int $primaryKey): void {
        $statement =  $this->selectPrefix() . 'WHERE '.$this->primaryKey.' = ?';
        $returnedFields = $this->db->run($statement, [$primaryKey])->fetch();
        foreach ($returnedFields as $key => $value) {
            $this->$key = $value;
        }
    }

    protected function selectPrefix(): string {
        return 'SELECT '. implode(', ', $this->publicFields) .' FROM '.$this->table. ' ';
    }

    protected function updateFields(): string {
        $fields = $this->publicFields;
        $key = array_search($this->primaryKey, $fields);
        if($key !== false){
            unset($fields[$key]);
        }
        return implode(' = ?, ', $fields) . ' = ?';
    }

    protected function saveValues(): array {
        $values = [];
        $fields = $this->publicFields;
        $key = array_search($this->primaryKey, $fields);
        if($key !== false){
            unset($fields[$key]);
        }
        foreach ($fields as $value) {
            $values[] = $this->$value;
        }
        return $values;
    }

    protected function insertFields(): object {
        $fields = $this->publicFields;
        $key = array_search($this->primaryKey, $fields);
        if($key !== false){
            unset($fields[$key]);
        }
        return (object) [
            'labels' => implode(', ', $fields), 
            'markers' => str_repeat('?, ', count($fields) - 1). '?', 
        ];
    }

    
}
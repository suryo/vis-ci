{php_open_tag}
<?php
$tables = [];
$i= ''; 
$select = [];
foreach ($this->crud_builder->getFieldRelation() as $field => $join): 
    $tables[] = $join['relation_table'];
    $count = array_count_values($tables);
    if (in_array($join['relation_table'], $tables)) {
        $i = $count[$join['relation_table']]-1;
        if ($i<=0) {
            $i = '';
        }
    }
    
    $select[] = $join['relation_table'].'.'.$join['relation_label'];

?>
<?php endforeach; ?>
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_{table_name} extends MY_Model {

    <?php $field_in_column = $this->crud_builder->getFieldShowInColumn(); ?>
private $primary_key    = '{primary_key}';
    private $table_name     = '{table_name}';
    public $field_search   = ['<?= implode("', '", array_merge($field_in_column,$select)); ?>'];
    <?php if ($this->input->post('sort_field')): 
    ?>public $sort_option = ['<?= $this->input->post('sort_field') ?>', '<?= $this->input->post('sort_by') ?>'];
    <?php else:
    ?>public $sort_option = ['{primary_key}', 'DESC'];
    <?php endif ?>

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
            'sort_option'   => $this->sort_option,
         );

        parent::__construct($config);
    }

    public function count_all($q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "{table_name}.".$field;

                if (strpos($field, '.')) {
                    $f_search = $field;
                }
                if ($iterasi == 1) {
                    $where .=  $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " .  $f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "{table_name}.".$field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "{table_name}.".$field;
                if (strpos($field, '.')) {
                    $f_search = $field;
                }

                if ($iterasi == 1) {
                    $where .= $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " .$f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "{table_name}.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        
        $this->sortable();
        
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        <?php
        $select[] = '{table_name}.*';
        $tables = [];
        $i= ''; 
        foreach ($this->crud_builder->getFieldRelation() as $field => $join): 
            $tables[] = $join['relation_table'];
            $count = array_count_values($tables);
            if (in_array($join['relation_table'], $tables)) {
                $i = $count[$join['relation_table']]-1;
                if ($i<=0) {
                    $i = '';
                }
            }
           
            $select[] = $join['relation_table'].'.'.$join['relation_label'].' as '.$join['relation_table'].'_'.$join['relation_label'];
            $select[] = $join['relation_table'].'.'.$join['relation_label'].' as '.$join['relation_label'];


        ?>$this->db->join('<?= $join['relation_table'] ; ?><?= $i > 0 ? ' '.$join['relation_table'].$i : '' ; ?>', '<?= $join['relation_table'].$i ; ?>.<?= $join['relation_value']; ?> = {table_name}.<?= $field; ?>', 'LEFT');
        <?php endforeach; ?>

        $this->db->select('<?= implode(",", $select); ?>');


        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            <?php
                foreach ($this->crud_builder->getFieldByType('current_user_id') as $field): 
                ?>$this->db->where($this->table_name.'.<?= $field ?>', get_user_data('id'));
        <?php endforeach; ?><?php
                foreach ($this->crud_builder->getFieldByType('current_user_pegawai_id') as $field): 
                ?>$this->db->where($this->table_name.'.<?= $field ?>', $this->session->userdata('sesi_pegawai'));
        <?php endforeach; ?>}

        return $this;
    }

}

/* End of file Model_{table_name}.php */
/* Location: ./application/models/Model_{table_name}.php */
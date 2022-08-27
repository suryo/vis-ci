<?php
defined('BASEPATH') or exit('No direct script access allowed');


class MY_Model extends CI_Model
{

    private $primary_key = 'id';
    private $table_name = 'table';
    private $field_search = [];
    public $sort_option = [];

    public function __construct($config = array())
    {
        parent::__construct();

        foreach ($config as $key => $val) {
            if (isset($this->$key))
                $this->$key = $val;
        }

        $this->load->database();
    }

    public function remove($id = NULL)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table_name);
    }

    public function change($id = NULL, $data = array())
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $data);

        return $this->db->affected_rows();
    }

    public function find($id = NULL, $select_field = [])
    {
        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->db->where("" . $this->table_name . '.' . $this->primary_key, $id);
        $query = $this->db->get($this->table_name);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function find_all()
    {
        $this->db->order_by($this->primary_key, 'DESC');
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function store($data = array())
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function get_all_data($table = '')
    {
        $query = $this->db->get($table);

        return $query->result();
    }


    public function get_single($where)
    {
        $query = $this->db->get_where($this->table_name, $where);

        return $query->row();
    }

    public function scurity($input)
    {
        return mysqli_real_escape_string($this->db->conn_id, $input);
    }

    public function generate_url($field, $text = null, $except = null)
    {
        $url = url_title($text);
        if ($except) {
            $this->db->where($this->primary_key . " != " . $except);
        }
        $this->db->order_by($this->primary_key, 'DESC');
        $data = $this->db->get_where($this->table_name, [$field => $url])->row();

        if ($data) {
            return $url . ($data->id += 1);
        }

        return $url;
    }

    public function export($table, $subject = 'file', $field_search = [])
    {
        $iterasi = 1;
        $where = NULL;
        $q = $this->scurity($this->input->get('q'));
        $field = $this->scurity($this->input->get('f'));
        if (empty($field)) {
            foreach ($field_search as $field) {
                $f_search = $table . '.' . $field;

                if (strpos($field, '.')) {
                    $f_search = $field;
                }

                if ($iterasi == 1) {
                    $where .= $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . $f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '(' . $where . ')';
        } else {
            $where .= "(" . $table . "." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->sortable();
        if (method_exists($this, 'join_avaiable') && method_exists($this, 'filter_avaiable')) {
            $this->join_avaiable()->filter_avaiable();
        }
        if (!empty($q)) {
            $this->db->where($where);
        }

        $this->load->library('excel');

        $result = $this->db->get($table);

        $this->excel->setActiveSheetIndex(0);

        $fields = $result->list_fields();

        $fields = array_unique($fields);



        $alphabet = 'ABCDEFGHIJKLMOPQRSTUVWXYZ';
        $alphabet_arr = str_split($alphabet);
        $column = [];

        foreach ($alphabet_arr as $alpha) {
            $column[] =  $alpha;
        }

        foreach ($alphabet_arr as $alpha) {
            foreach ($alphabet_arr as $alpha2) {
                $column[] =  $alpha . $alpha2;
            }
        }
        foreach ($alphabet_arr as $alpha) {
            foreach ($alphabet_arr as $alpha2) {
                foreach ($alphabet_arr as $alpha3) {
                    $column[] =  $alpha . $alpha2 . $alpha3;
                }
            }
        }

        foreach ($column as $col) {
            $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        }

        $col_total = $column[count($fields) - 1];

        //styling
        $this->excel->getActiveSheet()->getStyle('A1:' . $col_total . '1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'DA3232')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            )
        );

        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FFFFFF');

        $this->excel->getActiveSheet()->getStyle('A1:' . $col_total . '1')->getFont()->setColor($phpColor);

        $this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

        $this->excel->getActiveSheet()->getStyle('A1:' . $col_total . '1')
            ->getAlignment()->setWrapText(true);

        $col = 0;
        foreach ($fields as $field) {

            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, ucwords(str_replace('_', ' ', $field)));
            $col++;
        }

        $row = 2;
        foreach ($result->result() as $data) {
            $col = 0;
            foreach ($fields as $field) {
                $this->excel->getActiveSheet()->setCellValueExplicit($column[$col] . $row, $data->$field, PHPExcel_Cell_DataType::TYPE_STRING);
                //$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, '' . $data->$field);
                $col++;
            }

            $row++;
        }

        //set border
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $this->excel->getActiveSheet()->getStyle('A1:' . $col_total . '' . $row)->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->setTitle(ucwords($subject));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . ucwords($subject) . '-' . date('Y-m-d') . '.xls');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function pdf($table, $title)
    {
        $this->load->library('HtmlPdf');

        $iterasi = 1;
        $where = NULL;
        $q = $this->scurity($this->input->get('q'));
        $field = $this->scurity($this->input->get('f'));
        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = $table . '.' . $field;

                if (strpos($field, '.')) {
                    $f_search = $field;
                }
                if ($iterasi == 1) {
                    $where .= $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . $f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '(' . $where . ')';
        } else {
            $where .= "(" . $table . "." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->sortable();

        if (method_exists($this, 'join_avaiable') && method_exists($this, 'filter_avaiable')) {
            $this->join_avaiable()->filter_avaiable();
        }
        if (!empty($q)) {
            $this->db->where($where);
        }


        $config = array(
            'orientation' => 'l',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);



        $result = $this->db->get($table);
        $fields = $result->list_fields();
        $fields = array_unique($fields);

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf', [
            'results' => $result->result(),
            'fields' => $fields,
            'title' => $title
        ], TRUE);


        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table . '.pdf', 'H');
    }

    public function generate_id($suffix = null)
    {
        $format = $suffix . (new DateTime)->format('Ymd');
        $exist = $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE ' . $this->primary_key . '  LIKE "%' . $format . '%" ORDER BY ' . $this->primary_key . ' DESC');

        $numbering = '0001';
        if ($exist->num_rows()) {
            $last = $exist->row();
            $last_numbering = substr($last->{$this->primary_key}, -4);
            $next_number = $last_numbering += 1;
            $numbering = sprintf("%04d", $next_number);

            return $format . $numbering;
        } else {
            return $format . $numbering;
        }
    }

    public function sortable()
    {
        if (isset($this->sort_option) && count($this->sort_option)) {
            list($default_sort_field, $default_sort_type) = $this->sort_option;
        } else {
            $default_sort_field = $this->primary_key;
            $default_sort_type = 'DESC';
        }
        $sb = $this->input->get('sb');
        if ($sb) {
            $st = $this->input->get('st') == 'ASC' ? 'ASC' : 'DESC';
        } else {
            $sb = $default_sort_field;
            $st = $default_sort_type;
        }

        if ($sb) {
            if (in_array($sb, $this->field_search)) {
                $this->db->order_by($sb, $st);
            }
        } else {
            $this->db->order_by($this->table_name . '.' . $this->primary_key, "DESC");
        }
    }

    public function filter_query($param_name = 'filters')
    {
        $this->load->dbforge();
        $filter = $this->input->get($param_name);
        $query = '';
        $table_fields = $this->db->list_fields($this->table_name);
        if ($filter) {
            $filter = $this->input->get($param_name);

            if ($filter) {

                if (is_array($filter)) {
                    $arr = $filter;
                } else {
                    $arr = (array)(json_decode($filter));
                }


                foreach ($arr as $item) {
                    $logic_parent = isset($item->lg) ? $item->lg : 'and';
                    $item = (object)$item;

                    $qry_sub = '';
                    foreach ($item->co as $cond) {
                        $cond = (object)$cond;

                        $value = $cond->vl;
                        $field = $cond->fl;
                        if (!$field) {
                            continue;
                        }

                        if (!in_array(trim($field), $table_fields)) {
                            die(json_encode([
                                'status' => false,
                                'message' => 'field not exist',
                            ]));
                        }
                        $operator = $cond->op;
                        $logic = isset($cond->lg) ? $cond->lg : 'and';
                        $value = explode(',', $value);

                        $opr = $this->parse_operator($operator);

                        $use_logic = ($qry_sub ? $logic : '');
                        $use_logic = ' ' . $use_logic;

                        if ($operator == 'is_null') {
                            $qry_sub .= $use_logic . ' ' . $field . ' = ""';
                        } elseif ($operator == 'not_null') {
                            $qry_sub .= $use_logic . ' ' . $field . ' != ""';
                        } elseif ($operator == 'where_in') {
                            $qry_sub .= $use_logic . ' ' . $field . ' IN ("' . implode('","', $value) . '")';
                        } elseif ($operator == 'where_not_in') {
                            $qry_sub .= $use_logic . ' ' . $field . ' NOT IN ("' . implode('","', $value) . '")';
                        } elseif ($operator == 'like') {
                            $value = explode(',', $value[0]);
                            $qry_sub .= $use_logic . ' ' . $field . ' LIKE "' . $value[0] . '"';
                        } elseif (count((array)$value) == 2 && $operator == 'between') {
                            $qry_sub .= $use_logic . ' ' . $field . ' BETWEEN "' . $value[0] . '" AND "' . $value[1] . '"';
                        } elseif (count((array)$value) > 1) {
                            $in_set_query = '(';

                            $in_logic = '';
                            foreach ($value as $val) {
                                if ($val != '') {
                                    $in_set_query .= $in_logic . ' find_in_set("' . $val . '", ' . $field . ')';
                                    $in_logic = ' OR ';
                                }
                            }
                            $in_set_query .= ')';
                            $qry_sub .= $use_logic . ' ' . $in_set_query;
                        } else {
                            if ($value[0] !== '') {
                                $qry_sub .= $use_logic . ' ' . $field . ' ' . $opr . ' "' . $value[0] . '"';
                            }
                        }
                    }

                    $query .= $qry_sub ? (($query ? $logic_parent : ' ') . ' (' . $qry_sub . ') ') : '';
                }
            }
            if ($query) {
                $this->db->where($query);
            }
        }
    }

    public function parse_operator($operator = null)
    {
        switch ($operator) {
            case 'equal':
                $use = '=';
                break;
            case 'not_equal':
                $use = '!=';
                break;
            case 'greather':
                $use = '>';
                break;
            case 'greather_equal':
                $use = '>=';
                break;
            case 'smaller_equal':
                $use = '<=';
                break;
            case 'smaller':
                $use = '<';
                break;
            default:
                $use = '=';
                break;
        }
        return $use;
    }
}

/* End of file My_Model.php */
/* Location: ./application/core/My_Model.php */
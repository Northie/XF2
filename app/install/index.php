<?php

namespace installer;

class Install {

    public static function Install() {
        self::buildModel();
    }

    public static function buildModel() {
        $tables = \libs\models\dataStructure::Load()->getStructure();
        foreach ($tables as $table => $cols) {
            $relationships = 0;
            foreach ($cols as $col => $loc) {
                $tables[$table][$col]['show'] = 1;
                if ($col == '' || $col == 'id' || $col == 'unid' || strpos($col, 'password')) {
                    $tables[$table][$col]['show'] = 0;
                }

                $i = explode("_", $col);
                $c = array_pop($i);
                //look for empty or _ _ to find table
                $ta = array();
                $p = '';
                while (true) {
                    $p = array_pop($i);
                    if ($p == '' || is_null($p)) {
                        break;
                    }
                    array_unshift($ta, $p);
                    //$ta[] = $p;
                }
                $t = implode("_", $ta);
                if ($tables[$t][$c]) {
                    $tables[$table][$col]['join'] = array("table" => $t, "column" => $c);
                    $tables[$table][$col]['show'] = 0;
                    $tables[$table][$col]['filter'] = "relate($t,$c,*)";
                    $relationships++;
                } else {
                    switch (true) {
                        case (strpos($col, "email") > -1):
                            $tables[$table][$col]['filter'] = "toLink(*,*,'mailto')";
                            break;
                        case (strpos($col, "_on") > -1 || strpos($col, "timestamp") > -1):
                            $tables[$table][$col]['filter'] = "toDate('Y-m-d H:i:s',*)";
                            break;
                        case (strpos($col, "time") > -1 || strpos($col, "timestamp") > -1):
                            $tables[$table][$col]['filter'] = "toTimePeriod(*)";
                            break;
                        default:
                            $tables[$table][$col]['filter'] = "toString(*)";
                    }
                }
            }
            //if($relationships < 2) {
            $resource_groups[] = $table;
            //}
        }
        //print_r($resource_groups);
        //print_r($tables);

        $table_names = array_keys($tables);

        $str = '<?php' . "\n\n" . '$schema = ' . var_export($tables, 1) . ';';
        file_put_contents(XENECO_PATH . "libs/models/model.cache.php", $str);

        $crud = array("create", "read", "update", "destroy");

        for ($i = 0; $i < count($table_names); $i++) {

            $show = $hide = array();

            $dir = XENECO_PATH . "modules/" . $table_names[$i];

            if (!is_dir($dir)) {
                mkdir($dir);
            }
            $dir = XENECO_PATH . "views/" . $table_names[$i];

            if (!is_dir($dir)) {
                mkdir($dir);
            }

            foreach ($crud as $action) {

                $ns = "modules\\" . $table_names[$i] . ";";

                $p = XENECO_PATH . "modules/" . $table_names[$i] . "/" . $action . ".class.php";

                $c = '<?php
namespace ' . $ns . '
//class ' . $action . ' extends \modules\Default_Action {
//class ' . $action . ' extends \modules\Authenticated_Action {
class ' . $action . ' extends \modules\api {
	use \\libs\\rest\\' . $action . ' {
		\\libs\\rest\\' . $action . '::Execute as ' . \libs\misc\Tools::to_camel_case('rest ' . $action . ' Execute') . ';
	}
	public function __construct() {
		parent::__construct();
	}
	
	public function Execute() {
		if(!\Plugins\Plugins::Load()->DoPlugins("' . \libs\misc\Tools::to_camel_case('on Before ' . $table_names[$i] . ' ' . $action . ' Execute') . '",$this)) {
			return false;
		}
		
		$this->' . \libs\misc\Tools::to_camel_case('rest ' . $action . ' Execute') . '();
		\Plugins\Plugins::Load()->DoPlugins("' . \libs\misc\Tools::to_camel_case('on After ' . $table_names[$i] . ' ' . $action . ' Execute') . '",$this);
	}
}
';
                if (!file_exists($p)) {
                    file_put_contents($p, $c);
                }

                $ns = "views\\" . $table_names[$i] . ";";

                $c = '<?php
namespace ' . $ns . '
class ' . $action . ' extends \views\Default_View {
	
	public function __construct() {
		$this->template = "' . $table_names[$i] . '-' . $action . '.tpl.html";
	}
	
	public function Execute() {
		$obj = $this->app;
		
	}
}
';
                $p = XENECO_PATH . "views/" . $table_names[$i] . "/" . $action . ".class.php";

                if (!file_exists($p)) {
                    file_put_contents($p, $c);
                }
            }

            foreach ($tables[$table_names[$i]] as $col => $meta) {
                if ($meta['show']) {
                    $show[] = $col;
                } else {
                    $hide[] = $col;
                }
            }

            $str = '<?php
/**
 *
 * This file is automatically generated from your database
 * This fill will be re-written each time the schema script is run
 * Please do not modify it.
 *
 * You may use the corresponding concrete class to overwrite methods
 *
 */
namespace libs\models;
use libs\pdo;
abstract class _' . $table_names[$i] . ' extends Model {
	public $resource = "' . $table_names[$i] . '";
	protected function fieldVisibility() {
		$fields = array("show"=>' . var_export($show, 1) . ',"hide"=>' . var_export($hide, 1) . ');
		return $fields;
	}
}';
            $path = XENECO_PATH . "libs/models/" . $table_names[$i] . ".abstract.model.class.php";

            //overwrite abstract class

            file_put_contents($path, $str);

            $str2 = '<?php
/**
 *
 * This file is automatically generated from your database
 * This fill will only be written once for each table in your database
 *
 * You may use this class to overwrite default methods in the abstract version of this class
 *
 */
namespace libs\models;
use libs\pdo;
class ' . $table_names[$i] . ' extends _' . $table_names[$i] . ' {
	
}';
            $path2 = XENECO_PATH . "libs/models/" . $table_names[$i] . ".model.class.php";

            //do not overwrite concrete class

            if (!file_exists($path2)) {
                file_put_contents($path2, $str2);
            }
        }
    }

}
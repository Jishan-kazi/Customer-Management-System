<?php
    if (!function_exists('save')) {
        function save($dataToSave, $model)
        {
            //to insert & update
            $item = $model;
            // dd($dataToSave);
            foreach ($dataToSave as $key => $value) {
                // dd($item);
                $item->$key = $value;
            }
    
            if ($item->save()) {
                return $item->id;
            }
            return false;
        }
    }

?>
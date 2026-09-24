<?php
function readData($filename) {
    if (!file_exists($filename)) {
        return [];
    }
    $content = file_get_contents($filename);
    return json_decode($content, true) ?: [];
}

function writeData($filename, $data) {
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents($filename, $json, LOCK_EX);
}

function createRecord($filename, $record) {
    $data = readData($filename);
    
    $record['id'] = empty($data) ? 1 : max(array_column($data, 'id')) + 1;
    
    if (!isset($record['created_at'])) {
        $record['created_at'] = date('Y-m-d H:i:s');
    }
    if (!isset($record['updated_at'])) {
        $record['updated_at'] = date('Y-m-d H:i:s');
    }
    
    $data[] = $record;
    writeData($filename, $data);
    return $record['id'];
}

function getRecord($filename, $id) {
    $data = readData($filename);
    foreach ($data as $record) {
        if ($record['id'] == $id) {
            return $record;
        }
    }
    return null;
}

function updateRecord($filename, $id, $updatedData) {
    $data = readData($filename);
    foreach ($data as &$record) {
        if ($record['id'] == $id) {
            $record = array_merge($record, $updatedData);
            $record['updated_at'] = date('Y-m-d H:i:s');
            writeData($filename, $data);
            return true;
        }
    }
    return false;
}

function deleteRecord($filename, $id) {
    $data = readData($filename);
    $data = array_filter($data, function($record) use ($id) {
        return $record['id'] != $id;
    });
    writeData($filename, array_values($data));
    return true;
}

function findRecords($filename, $criteria) {
    $data = readData($filename);
    $result = [];
    foreach ($data as $record) {
        $match = true;
        foreach ($criteria as $key => $value) {
            if (!isset($record[$key]) || $record[$key] != $value) {
                $match = false;
                break;
            }
        }
        if ($match) {
            $result[] = $record;
        }
    }
    return $result;
}
?>